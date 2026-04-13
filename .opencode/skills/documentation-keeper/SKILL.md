---
nombre: documentation-keeper
descripcion: Obliga a mantener documentacion viva y alineada con el codigo del proyecto.
---

# documentation-keeper

## Instrucciones
- Actualizar documentacion en el mismo bloque de trabajo donde cambia el codigo.
- Registrar cambios relevantes en `docs/cambios.md`.
- Verificar consistencia entre docs y comportamiento real antes de cerrar.

## Checklist accionable
- Revisar `docs/levantamientoUi.md` si cambia UI.
- Revisar `docs/arquitectura.md` y `docs/modulos.md` si cambia estructura.
- Revisar `docs/baseDeDatos.md` y `database/sql/esquemaCompleto.md` si cambia schema.
- Revisar `docs/seguridad.md` si cambia proteccion o permisos.
- Revisar `docs/librerias.md` si se agregan paquetes.

## Senales de error o desviacion
- Codigo nuevo sin reflejo en docs.
- Docs que mencionan modulos o tablas inexistentes.
- `docs/cambios.md` desactualizado despues de una fase importante.
