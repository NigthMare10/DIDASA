---
nombre: laravel-modular-architecture
descripcion: Refuerza la arquitectura modular y desacoplada del monolito Laravel del proyecto.
---

# laravel-modular-architecture

## Instrucciones
- Mantener cada caso de uso dentro de su modulo en `app/Modulos`.
- Dejar controladores delgados y mover logica a acciones o servicios.
- Usar Form Requests para toda validacion de entrada.
- Usar eventos/listeners para efectos secundarios que no deben ensuciar el flujo principal.

## Checklist accionable
- Controller sin logica de negocio compleja.
- Request dedicada para validar entrada.
- Action o Service por caso de uso relevante.
- Dependencias entre modulos claras y sin circularidad.
- Decisiones no triviales documentadas.

## Criterios para evitar sobreingenieria
- No crear repositorios si Eloquent cubre el escenario.
- No agregar DTOs por rutina si el request validado ya es suficiente.
- No convertir todo en eventos; usarlos solo donde desacoplan mejor.

## Senales de error o desviacion
- Queries complejas dentro de Blade.
- Controladores con multiples ramas de negocio.
- Modulos leyendo o escribiendo internamente en detalles de otros modulos sin capa clara.
