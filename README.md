# Harthora

Aplicación web de una inmobiliaria de lujo (solo venta), desarrollada con Laravel como proyecto final de Desarrollo Web en Entorno Servidor (2.º DAW).

## Cargar la base de datos

```bash
php artisan migrate:fresh --seed
```

Borra todas las tablas, las vuelve a crear y las rellena con datos de prueba.

## Usuarios de prueba

Todos los usuarios de prueba tienen la contraseña **`harthora`** (en minúsculas).

| Rol | Email | Contraseña |
|---|---|---|
| Cliente | cliente@harthora.test | harthora |
| Cliente premium | premium@harthora.test | harthora |
| Comercial (senior) | comercial@harthora.test | harthora |
| Financiero | financiero@harthora.test | harthora |
| Directivo | directivo@harthora.test | harthora |

El resto de usuarios generados al azar también usan la contraseña `harthora`.

> Estos usuarios solo existen para desarrollo y pruebas.
