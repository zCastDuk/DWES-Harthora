# Harthora · Sprint 3

**Periodo:** 19 de octubre – 1 de noviembre de 2026
**Objetivo:** disponer de un esqueleto web seguro y coherente sobre el que añadir funcionalidades.

---

Usuarios de prueba (contraseña `harthora`): `cliente@`, `premium@`, `comercial@`, `financiero@` y `directivo@harthora.test`.

---

## 1. Autenticación y separación de zonas

### 1.1 Sistema de autenticación elegido
La autenticación se ha hecho **a mano**, sin kits de inicio, para entender cada paso. Se apoya en las herramientas que Laravel trae de serie: `Auth::attempt()` para comprobar email y contraseña, contraseñas cifradas automáticamente, protección CSRF en los formularios y renovación de la sesión al entrar y salir.

- **Un único login** para clientes y empleados (un solo `User` con perfiles. Queda pendiente revisar la usabilidad y experiencia de usuario (en las páginas de error los botones no se han ocultado)
- **Registro solo para clientes.** Las cuentas de empleado las crea la dirección.
- **Mensaje de error genérico** en el login («el correo o la contraseña no son correctos»), sin indicar cuál de los falla por razones de seguridad.

### 1.2 Zona pública
Inicio, la agencia (about), contacto, catálogo y ficha de cada casa (*). Login y registro también son públicos, pero solo para quien no ha iniciado sesión.

* *Queda pendiente implementar la vista individual de cada casa.

### 1.3 Zona privada
Perfil y cierre de sesión (comunes a todos), y un panel por cada perfil de empleado: comercial, financiero y directivo.

### 1.4 Redirección según el perfil tras iniciar sesión
| Perfil | Destino |
|---|---|
| Cliente (y premium) | Catálogo |
| Comercial | `commercial/dashboard` |
| Financiero | `financial/dashboard` |
| Directivo | `management/dashboard` |


---

## 2. Rutas

### 2.1 Organización por áreas
- **Públicas:** sin middleware.
- **Solo invitados (`guest`):** login y registro.
- **Con sesión (`auth`):** logout y perfil, más un subgrupo por rol con su prefijo (`client`, `commercial`, `financial`, `management`).

### 2.2 Nombres de las rutas

Todas las rutas que se usan desde vistas o controladores tienen nombre (`properties`, `contact.store`, `commercial.dashboard`…). 

### 2.3 Middleware aplicado
| Middleware | Para qué |
|---|---|
| `guest` | Quien ya ha iniciado sesión no vuelve a ver el login ni el registro |
| `auth` | La zona privada exige sesión iniciada |
| `role` (propio) | Cada perfil entra solo en su zona; si no, error 403 |

### 2.4 Mapa de rutas
| Zona | Dirección | Nombre |
|---|---|---|
| Pública | `/` | `home` |
| Pública | `/about` | `about` |
| Pública | `/contact` (GET y POST) | `contact`, `contact.store` |
| Pública | `/properties` | `properties` |
| Pública | `/properties/{property}` | `properties.show` |
| Invitados | `/login` (GET y POST) | `login` |
| Invitados | `/register` (GET y POST) | `register` |
| Con sesión | `/logout` (POST) | `logout` |
| Con sesión | `/profile` | `profile` |
| Comercial | `/commercial/dashboard` | `commercial.dashboard` |
| Financiero | `/financial/dashboard` | `financial.dashboard` |
| Directivo | `/management/dashboard` | `management.dashboard` |

**Previstas para próximos sprints** (ya anotadas en `web.php`): visitas y favoritos del cliente; agenda, casas, ventas y comisiones del comercial; listado, detalle, validación y rechazo de ventas del financiero.

---

## 3. Roles y permisos

### 3.1 Los cinco perfiles
Cliente, cliente premium, comercial, financiero y directivo.

### 3.2 Reglas de cada perfil
| Perfil | Puede |
|---|---|
| Cliente | Ver el catálogo general y su perfil. Más adelante: favoritos y visitas. |
| Cliente premium | Lo mismo, y además las casas exclusivas durante su primer mes. |
| Comercial | Su panel. Editar solo las casas que tiene asignadas. |
| Financiero | Su panel. Validar o rechazar ventas pendientes y ver los datos del comprador. |
| Directivo | Su panel. Editar cualquier casa y ver los datos del comprador. No interviene en las ventas. |

### 3.3 Cómo se comprueba el rol
El modelo `User` tiene un método `roles()` que devuelve el rol de la persona: `client` para clientes, o el puesto del agente (`commercial`, `financial` o `management`). El middleware `role` compara ese rol con el que permite cada grupo de rutas.

---

## 4. Policies

### 4.1 Las cinco policies previstas
| Policy | Decide |
|---|---|
| **Property** | Quién ve una casa y quién la edita |
| **Sale** | Quién valida ventas y quién ve los datos del comprador |
| Visit | Quién solicita, confirma, aplaza o cancela una visita |
| Commission | Cada comercial ve solo sus comisiones; el financiero, todas |
| User | Solo la dirección gestiona usuarios y roles |

### 4.2 PropertyPolicy
- **Ver una casa:** si ya está publicada en el catálogo general, la ve cualquiera. Si aún no, solo los empleados y, si es exclusiva en su mes premium, los clientes premium.
- **Editar una casa:** el directivo o el comercial que la tiene asignada.

### 4.3 SalePolicy
- **Validar o rechazar:** solo el financiero, y solo si la venta sigue pendiente (no se puede validar dos veces).
- **Ver los datos del comprador:** solo el financiero y la dirección.

---

## 5. Validación con FormRequest

### 5.1 Formularios existentes con más de dos campos
Registro (8 campos) y contacto (3 campos). El login tiene solo dos, pero también usa FormRequest por la posible implementación de campos extras (checkbox).

### 5.2 FormRequest creados
| FormRequest | Valida |
|---|---|
| `RegisterRequest` | Datos de la cuenta y del perfil de cliente. Email y NIF no repetidos; contraseña repetida y con la política de seguridad. Mensajes en español. |
| `LoginRequest` | Email y contraseña obligatorios. Si son correctos lo decide `Auth::attempt()`. |
| `ContactRequest` | Nombre, email y mensaje. El formulario es de demostración: valida y da las gracias, sin enviar correo (el envío llegará en el Sprint 5). |

---

## 6. Componentes de vista reutilizables

| Componente | Qué hace |
|---|---|
| `forms.input` | Campo completo: etiqueta, caja, valor anterior (`old`) y mensaje de error. Admite tipo, placeholder y si es obligatorio. |
| `forms.label` | Etiqueta de un campo |
| `forms.textarea` | Cuadro de texto largo (mensaje de contacto) |
| `layouts.app` | Plantilla de la web pública (menú arriba y pie) |
| `layouts.panel` | Plantilla común a los paneles de los tres perfiles de empleado. El menú lateral con los enlaces de cada rol se completará cuando existan sus páginas. |
| `nav` y `footer` | Menú y pie. El menú cambia según haya sesión o no. |

**Dónde se reutilizan:** en los formularios de login, registro y contacto, y en todas las páginas a través de los layouts.

**Pendientes:** `select`, `date` y `checkbox` se crearán cuando haya formularios que los usen (visitas, ventas y gestión de casas).

---

## 7. Pruebas

Pendiente. De momento se mantiene la prueba de relaciones del Sprint 2.

---

## 8. Cambios en el modelo de datos

### 8.1 Propietarios como empresas (promotoras y estudios de arquitectura)
Los propietarios dejan de ser personas: ahora son empresas, con razón social, CIF, dirección, teléfono, email, tipo (`developer` o `architecture_studio`), logo, web y descripción. Esto permitirá una ficha pública de cada empresa más adelante.

---

## 9. Comprobación al cerrar el sprint

-  Un usuario puede registrarse o iniciar sesión.
-  Cada perfil llega a su zona y no puede entrar en la de otro (error 403).
-  Los formularios de registro y contacto completan un flujo validado con componentes reutilizables.

**Páginas que de momento son esqueleto:** perfil y dashboards de empleados. Su contenido se completará en los próximos sprints.

---

## 10. Planificación de los CRUD (próximos sprints)

Un CRUD (Create, Read, Update, Delete) es el conjunto de operaciones para crear, ver, modificar y borrar los registros de una tabla. El proyecto incluirá cinco CRUD completos (requisito M5), según la retroalimentación del Sprint 1. No se implementan en este sprint.

| CRUD | Perfil que lo gestiona | Particularidades |
|---|---|---|
| Properties (casas) | Dirección; el comercial, solo sus casas asignadas | Solo la dirección modifica precios y asignaciones. No se puede borrar una casa con ventas. |
| Zones (zonas) | Dirección | No se puede borrar una zona con casas. |
| Features (extras) | Dirección | No se puede borrar un extra asignado a casas sin decidir qué pasa con la pivote. |
| Visits (visitas) | Cliente (crear y cancelar) y comercial (confirmar y aplazar) | Respeta las reglas de agenda: franjas, días y solapamientos. Cancelar = borrar. |
| Sales (ventas) | Comercial (proponer) y financiero (validar o rechazar) | Las ventas rechazadas se conservan como historial. Pendiente de decidir: borrado solo de propuestas pendientes. |
