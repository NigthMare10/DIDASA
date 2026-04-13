---
nombre: ui-parity-review
descripcion: Verifica que la interfaz mantenga maxima fidelidad visual y funcional contra la referencia del proyecto DIDASA.
---

# ui-parity-review

## Instrucciones
- Revisar cada pantalla contra `docs/levantamientoUi.md` y la referencia visual disponible.
- Comparar layout, jerarquia, textos, iconografia, espaciados, estados vacios y responsive.
- Registrar en `docs/cambios.md` cualquier desviacion inevitable.

## Checklist accionable
- Validar navbar, hero, cards, tabs, modales y CTAs.
- Confirmar textos visibles y orden visual.
- Revisar foco, hover, disabled, errores y estados vacios.
- Verificar escritorio, tablet y movil.
- Confirmar que formularios y resúmenes reaccionen sin romper estructura.

## Diferencias permitidas
- Ajustes minimos por fuente o render del navegador.
- Extensiones funcionales cuando el estado real ya no sea vacio, siempre documentadas.

## Diferencias no permitidas
- Redisenar bloques.
- Cambiar copy o jerarquia visual sin motivo tecnico.
- Sustituir iconografia por otra de estilo incompatible.

## Senales de desviacion
- Botones o cards con radios/espaciados distintos al patron.
- Layout de dos columnas roto en cotizacion o agenda.
- Responsive que esconda informacion clave sin reemplazo claro.
