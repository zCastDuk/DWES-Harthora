# Harthora · Base de datos (Sprint 2)

Documentación del modelo de datos final: tablas, relaciones y, sobre todo, **las decisiones de diseño** que no se ven leyendo solo las migraciones.

## 1. Diagrama entidad-relación

- [Ver el diagrama (SVG)](Modelo_ER_harthora.svg)
- [Abrirlo en el visor de draw.io](https://viewer.diagrams.net/?nav=1&lightbox=1#Uhttps%3A%2F%2Fraw.githubusercontent.com%2FzCastDuk%2FDWES-Harthora%2Fmain%2Fdocs%2FDocumentacion%2FModelo_ER_harthora.svg) (con zoom)

El SVG lleva el diagrama incrustado, así que también se puede abrir y editar directamente en draw.io.

## 2. Tablas y relaciones

Las entidades ya se describieron en la ficha del Sprint 1; aquí se resume cómo han quedado implementadas.

| Tabla | Qué guarda | Relaciones |
|---|---|---|
| `users` | Datos de acceso comunes a cualquier persona con cuenta. `type`: `client` o `agent` | 1:1 con `clients` o con `agents` |
| `clients` | Perfil de cliente: NIF, dirección fiscal y si es premium | Pertenece a un `user`. Tiene favoritos, visitas y compras |
| `agents` | Perfil de agente: puesto (`role`) y fecha de contratación | Pertenece a un `user`. Lleva casas, atiende visitas, vende y valida ventas |
| `owners` | Propietarios de las casas (solo datos de contacto) | 1:N con `properties` |
| `zones` | Barrio, ciudad, provincia y país | 1:N con `properties` |
| `properties` | Las viviendas en venta | Pertenece a un propietario, un comercial y una zona |
| `features` | Catálogo de extras (piscina, vistas al mar…) con su nivel de sobrecoste | N:N con `properties` |
| `visits` | Visita de un cliente a una casa, con el comercial, en una fecha y franja | Pertenece a un cliente, una casa y un agente |
| `sales` | Propuestas de venta y su resolución | Pertenece a una casa, un cliente (comprador), un comercial y un financiero (`validated_by`) |
| `commissions` | Comisión del comercial por una venta validada | 1:1 con `sales` |

**Tablas pivote con columnas propias**

| Pivote | Une | Columnas extra |
|---|---|---|
| `favorites` | `clients` ↔ `properties` | `note` (nota personal), `price_drop_alert` (aviso de bajada de precio) |
| `feature_property` | `properties` ↔ `features` | `detail` (detalle del extra en esa casa), `estimated_value` (sobrecoste estimado) |

Se declaran en los modelos con `belongsToMany(...)->withPivot(...)` y se manejan con `attach()` y `updateExistingPivot()`.

## 3. Decisiones de diseño

### Personas: `users` + perfiles `clients` / `agents`
Todas las personas con cuenta están en `users`, porque el inicio de sesión es común. Lo específico de cada tipo va en su propia tabla, unida 1:1 (`user_id` único). Así un cliente no arrastra columnas de agente vacías y al revés. En la ficha del Sprint 1 esto figuraba como posible ampliación; se ha incorporado ya en el diseño.

### Agentes: el puesto es una columna
Comercial, financiero y directivo no tienen atributos propios, así que no tienen tabla: se distinguen con `agents.role`. Cada agente ocupa un único rol:
- **Comercial**: lleva casas, atiende visitas y propone ventas.
- **Financiero**: valida o rechaza ventas. No lleva casas.
- **Directivo**: no interviene en las ventas.

La categoría **novato / senior no se guarda**: se calcula a partir de `hire_date`, para que no pueda quedarse desactualizada.

### Comisiones
Solo cobra comisión el comercial que participa en una venta **validada**. El porcentaje depende de su antigüedad en la fecha de la venta:

| Antigüedad | Porcentaje |
|---|---|
| Menos de 5 años (novato) | 5 % |
| Desde 5 años (senior) | 10 % |
| Cada 3 años más | +2 % |
| Tope | 26 % |

Las reglas están como constantes en el modelo `Agent` (`commissionPercentageAt()`), en un único sitio. En `commissions` se guardan el porcentaje y el importe ya calculados, para que no cambien si en el futuro cambian las reglas.

### Ventas: el precio se copia
`sales.price` repite el precio de la casa **a propósito**: es una instantánea del precio en el momento de la venta. Si después se modifica `properties.price`, la venta y su comisión siguen reflejando lo que se pagó.

Las ventas tienen tres estados (`pending`, `validated`, `rejected`). Las rechazadas no se borran: quedan como historial de operaciones que no salieron, con su motivo.

### Propietarios sin cuenta
Los propietarios no usan la aplicación, por eso `owners` es una tabla independiente de `users`. Cada casa tiene un único propietario.

### Zonas y direcciones
- La zona guarda barrio (obligatorio), ciudad, provincia y país. El país está pensado para una posible ampliación fuera de España. Se filtra por barrio y por ciudad.
- La **dirección y el código postal van en la casa**, no en la zona: un barrio puede tener varios códigos postales y un código postal puede abarcar varios barrios. Si existe pedanía, va en la dirección.

### Catálogo exclusivo
`properties.is_exclusive` es independiente del estado (`available`, `reserved`, `sold`): una casa puede estar disponible y ser exclusiva a la vez. Las exclusivas solo las ven los clientes premium.

### Extras y sobrecoste
Cada extra tiene un nivel de sobrecoste (`surcharge_tier`) según su naturaleza:

| Nivel | Tipo de extra | Sobrecoste |
|---|---|---|
| `low` | Experiencial (vistas, luz, entorno) | Menos de 10.000 € |
| `medium` | Ubicación o acceso | 10.000 – 20.000 € |
| `high` | Requiere construcción (piscina, bodega…) | 20.000 – 25.000 € |

El valor concreto en cada casa se guarda en la pivote (`estimated_value`). Puede haber casas "estándar" sin ningún extra.

### Visitas
- Franjas fijas de una hora, de lunes a viernes, de 9:00 a 19:00.
- Estados: `pending`, `confirmed`, `completed`. **Cancelar una visita es borrarla**, por eso no existe el estado "cancelada".

## 4. Reglas que garantiza la base de datos

| Regla | Cómo |
|---|---|
| Un email por usuario | `users.email` único |
| Un NIF por cliente y por propietario | `nif` único |
| Una persona solo tiene un perfil de cliente o de agente | `user_id` único en `clients` y `agents` |
| No hay zonas duplicadas | Único en barrio + ciudad + provincia + país |
| Una casa no recibe dos visitas a la vez | Único en casa + fecha + franja |
| Un agente no atiende dos visitas a la vez | Único en agente + fecha + franja |
| Un cliente no tiene dos visitas a la vez | Único en cliente + fecha + franja |
| Un cliente no guarda dos veces la misma casa | Único en `favorites` (cliente + casa) |
| Una casa no tiene dos veces el mismo extra | Único en `feature_property` (casa + extra) |
| Una venta genera como mucho una comisión | `commissions.sale_id` único |
| No se pierden datos con historial | `restrictOnDelete`: no se puede borrar una zona, propietario o agente con casas, ni una casa, cliente o agente con ventas |
| Los datos dependientes desaparecen con su dueño | `cascadeOnDelete`: al borrar un usuario se borra su perfil; al borrar una casa, sus favoritos, extras y visitas |

Otras reglas (que el validador sea financiero, que solo haya una venta validada por casa, que un cliente normal no vea casas exclusivas…) no se pueden expresar en la base de datos y se aplicarán en la aplicación (policies, validaciones y scopes) en próximos sprints.

## 5. Datos de prueba

```bash
php artisan migrate:fresh --seed
```

| Seeder | Qué crea |
|---|---|
| `ZoneSeeder` | 35 zonas reales (Madrid, Barcelona, País Vasco y costa), desde `database/data/zones.php` |
| `FeatureSeeder` | 22 extras con su nivel de sobrecoste, desde `database/data/features.php` |
| `TestUserSeeder` | Un usuario fijo por rol para iniciar sesión (ver [README](../../README.md)) |
| `PeopleSeeder` | 15 propietarios, 20 clientes (5 premium) y 8 agentes (5 comerciales, 2 financieros, 1 directivo), contando los fijos |
| `PropertySeeder` | 40 casas repartidas entre las zonas, propietarios y comerciales existentes, con sus extras y los favoritos de los clientes |
| `VisitSeeder` | 30 visitas a casas publicadas y no vendidas |
| `SaleSeeder` | Ventas coherentes con el estado de cada casa, y la comisión de las validadas |

Los datos respetan las reglas de negocio: casas vendidas con su venta validada y su comisión, casas reservadas con una venta pendiente, comerciales como únicos responsables de casas, financieros como únicos validadores y clientes no premium sin acceso a casas exclusivas.

## 6. Pruebas

`tests/Feature/RelationshipsTest.php` comprueba un ejemplo de cada tipo de relación:
- **1:1**: usuario ↔ cliente.
- **1:N**: zona → casas.
- **N:N con columnas extra**: cliente ↔ favoritos, creando, leyendo y actualizando las columnas de la pivote.

```bash
php artisan test
```

## 7. Mejoras previstas

- **Propietarios como empresas**: los propietarios de casas de lujo suelen ser promotoras o estudios de arquitectura. Habría que adaptar `owners` (apellidos opcionales y CIF en lugar de NIF) y los datos de prueba.
