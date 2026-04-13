---
nombre: mysql-schema-governance
descripcion: Gobierna el diseno del esquema MySQL, sus relaciones, indices y documentacion SQL final.
---

# mysql-schema-governance

## Instrucciones
- Diseñar tablas con nombres claros, claves foraneas explicitas e indices utiles.
- Validar que cada columna tenga tipo correcto para MySQL objetivo.
- Documentar cualquier decision especial en `docs/baseDeDatos.md` y `database/sql/esquemaCompleto.md`.

## Checklist accionable
- Tabla con PK y timestamps si aplica.
- FK con `cascadeOnDelete` o `nullOnDelete` justificado.
- Unicos e indices creados para busquedas frecuentes.
- Campos monetarios en `DECIMAL(10,2)` o similar.
- Campos de estado definidos y documentados.

## Triggers
- Usar solo si una regla no puede mantenerse de forma confiable desde aplicacion o restricciones.
- Si no se usan, dejar razon escrita.

## Senales de error o desviacion
- Tabla sin indices para filtros frecuentes.
- FK faltantes entre tablas relacionadas.
- Reglas de negocio criticas escondidas en SQL sin documentacion.
