---
nombre: test-and-regression-guard
descripcion: Previene regresiones funcionales y visuales en los flujos criticos del portal DIDASA.
---

# test-and-regression-guard

## Instrucciones
- Cubrir con pruebas unitarias y feature los flujos mas sensibles.
- Complementar con chequeos manuales de UI cuando la automatizacion no capture paridad visual.

## Checklist accionable
- Probar inicio, registro de vehiculo, cotizacion, agenda y fidelidad.
- Verificar que agendar genere orden de trabajo.
- Ejecutar build frontend despues de cambios de estilos.
- Revisar estados vacios y botones deshabilitados.

## Checks manuales sugeridos
- Confirmar navbar y heroes.
- Probar modal de vehiculos.
- Probar resumen de cotizacion y agenda.
- Revisar responsive en puntos de quiebre principales.

## Senales de deuda riesgosa
- Cambios sin pruebas en flujos criticos.
- Bugs visuales repetitivos por falta de componentes reutilizables.
- Datos o reglas repetidos en varias capas sin una sola fuente de verdad.
