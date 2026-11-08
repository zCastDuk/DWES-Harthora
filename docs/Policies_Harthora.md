# Policies de Harthora

8 de noviembre de 2026

Cinco policies para el Sprint 4, con los métodos que llevará cada una y quién puede usarlos. Cada método es una acción y devuelve `true` o `false`; marca cada uno cuando lo escribas y lo pruebes.

## 1. PropertyPolicy

- [ ] `view(?User $user, Property $property)`: si la casa ya está publicada, todos (también invitados). Si no lo está, solo clientes premium y empleados.
- [ ] `create(User $user)`: solo dirección.
- [ ] `update(User $user, Property $property)`: solo dirección.
- [ ] `delete(User $user, Property $property)`: solo dirección, y nunca una casa con ventas.
- [ ] `favorite(User $user, Property $property)`: solo clientes (normales y premium) y solo si pueden ver esa casa (reutiliza `view`).

## 2. SalePolicy

- [ ] `create(User $user, Property $property)`: la casa tiene que estar disponible. Cliente: si puede ver la casa. Comercial: si la casa es suya.
- [ ] `updatePrice(User $user, Sale $sale)`: el comercial que lleva la casa, solo mientras la venta esté `pending`.
- [ ] `validate(User $user, Sale $sale)`: financiero, solo si está `pending`.
- [ ] `reject(User $user, Sale $sale)`: financiero, solo si está `pending`.
- [ ] `view(User $user, Sale $sale)`: financiero y dirección, todas. Comercial: solo las suyas. Cliente: solo las suyas.
- [ ] `viewBuyerData(User $user, Sale $sale)`: financiero y dirección (ya existe).

## 3. VisitPolicy

- [ ] `create(User $user, Property $property)`: cliente, si puede ver la casa y no está vendida. Comercial, si la casa es suya (la visita nace ya confirmada).
- [ ] `view(User $user, Visit $visit)`: el cliente, las suyas. El comercial, las de sus casas. La dirección, todas.
- [ ] `update(User $user, Visit $visit)` (aplazar): el cliente, las suyas; el comercial, las de sus casas. Solo si está `pending` o `confirmed`.
- [ ] `confirm(User $user, Visit $visit)`: solo el comercial de esa casa, y solo si está `pending`.
- [ ] `cancel(User $user, Visit $visit)` (o `delete` si cancelar borra la visita): el cliente, las suyas; el comercial, las de sus casas. Solo si está `pending` o `confirmed`.

Si el comercial crea la visita para un cliente, comprobar al guardarla que ese cliente puede ver la casa. La policy no sabe qué cliente se ha elegido.

## 4. ZonePolicy

- [ ] `viewAny(User $user)`: solo dirección (listado del panel).
- [ ] `create(User $user)`: solo dirección.
- [ ] `update(User $user, Zone $zone)`: solo dirección.
- [ ] `delete(User $user, Zone $zone)`: solo dirección, y solo si la zona no tiene casas.

## 5. FeaturePolicy

- [ ] `viewAny(User $user)`: solo dirección.
- [ ] `create(User $user)`: solo dirección.
- [ ] `update(User $user, Feature $feature)`: solo dirección.
- [ ] `delete(User $user, Feature $feature)`: solo dirección, y solo si ninguna casa tiene ese extra (si no, la pivote lo borraría en cascada de todas).

## 6. Sexta policy: candidatas

Tres opciones para pensar. Cada una con los métodos que tendría.

| Policy | Métodos | Regla que le da contenido |
| --- | --- | --- |
| `CommissionPolicy` | `viewAny`, `view` | El comercial ve solo sus comisiones; financiero y dirección, todas. Nadie las crea ni edita a mano: se generan al validar la venta. |
| `UserPolicy` | `viewAny`, `view`, `update`, `delete`, `changeRole` | La dirección gestiona usuarios. Cada uno ve y edita su propio perfil. Nadie se borra a sí mismo ni se cambia el rol. |
| `OwnerPolicy` | `viewAny`, `create`, `update`, `delete` | Solo la dirección gestiona las empresas propietarias. No se borra una empresa con casas. |
