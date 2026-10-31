# Harthora · Sprint 3

**Periodo:** 19 de octubre – 1 de noviembre de 2026
**Objetivo:** disponer de un esqueleto web seguro y coherente sobre el que añadir funcionalidades.

---
## ¿Cómo iniciar el proyecto con sus vistas?
Para poder visualizar la aplicación web con los estilos aplicados, se recomienda ejecutar estos comandos en la temrinal

- **npm intall**
    Se ejecuta solo UNA vez. Realiza la descarga de Tailwind y Vite para cargar correctamente las vistas.
- **npm run build**
    Genera las versiones de CSS una vez.
- **php artisan serve**
    Pone en marcha el proyecto. 
---


## 1. Autenticación y separación de zonas

### 1.1 Sistema de autenticación elegido

### 1.2 Zona pública

### 1.3 Zona privada

### 1.4 Redirección según el perfil tras iniciar sesión

---

## 2. Rutas

### 2.1 Organización por áreas

### 2.2 Nombres de las rutas

### 2.3 Middleware aplicado

### 2.4 Mapa de rutas

---

## 3. Roles y permisos

### 3.1 Los cinco perfiles

### 3.2 Reglas de cada perfil

### 3.3 Cómo se comprueba el rol

---

## 4. Policies

### 4.1 Las cinco policies previstas

### 4.2 Policy implementada 1

### 4.3 Policy implementada 2

---

## 5. Validación con FormRequest

### 5.1 Formularios existentes con más de dos campos

### 5.2 FormRequest creados

---

## 6. Componentes de vista reutilizables

### 6.1 Input

### 6.2 Label

### 6.3 Select

### 6.4 Fecha

### 6.5 Checkbox

### 6.6 Dónde se reutilizan

---

## 7. Pruebas

### 7.1 Autenticación

### 7.2 Rutas

### 7.3 Permisos

### 7.4 Validación

### 7.5 Resultado de la ejecución

---

## 8. Cambios en el modelo de datos

### 8.1 Propietarios como empresas (promotoras y estudios de arquitectura)

---

## 9. Comprobación al cerrar el sprint

---

## 10. Ampliación A4: regla de validación personalizada

---

## 11. Retroalimentación del Sprint 1 aplicada en este sprint

## 12. Planificación de los CRUD (próximos sprints)

Un CRUD (Create, Read, Update, Delete) es el conjunto de operaciones para crear, ver, modificar y borrar los registros de una tabla. El proyecto incluirá cinco CRUD completos (requisito M5), según la retroalimentación del Sprint 1. No se implementan en este sprint.

| CRUD | Perfil que lo gestiona | Particularidades |
|---|---|---|
| Properties (casas) | Dirección; el comercial, solo sus casas asignadas | Solo la dirección modifica precios y asignaciones. No se puede borrar una casa con ventas. |
| Zones (zonas) | Dirección | No se puede borrar una zona con casas. |
| Features (extras) | Dirección | No se puede borrar un extra asignado a casas sin decidir qué pasa con la pivote. |
| Visits (visitas) | Cliente (crear y cancelar) y comercial (confirmar y aplazar) | Respeta las reglas de agenda: franjas, días y solapamientos. Cancelar = borrar. |
| Sales (ventas) | Comercial (proponer) y financiero (validar o rechazar) | Las ventas rechazadas se conservan como historial. Pendiente de decidir: borrado solo de propuestas pendientes. |
