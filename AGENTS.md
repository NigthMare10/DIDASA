# AGENTS.md

## Contexto del proyecto
- Aplicacion web replicada desde una referencia visual existente del portal cliente DIDASA Tecnicentro.
- Backend obligatorio en Laravel; base de datos objetivo en MySQL.
- Prioridad absoluta en cada tarea: 1) paridad visual, 2) arquitectura mantenible, 3) seguridad, 4) documentacion viva.
- Si falta evidencia visual o funcional, documentar el supuesto en `docs/cambios.md`; no inventar pantallas ni comportamientos sin dejar rastro.

## Reglas de ejecucion
- Confirmar siempre que el trabajo se hace dentro de `C:\Users\cesar.vivas\Desktop\Didasa`.
- Antes de tocar UI, revisar `docs/levantamientoUi.md` y comparar con la referencia.
- Antes de tocar arquitectura o schema, revisar `docs/arquitectura.md`, `docs/modulos.md` y `docs/baseDeDatos.md`.
- Toda diferencia inevitable contra referencia debe quedar documentada con motivo tecnico, impacto y alcance.
- No hacer cambios masivos sin actualizar documentacion en la misma sesion.

## Convenciones de codigo
- Variables, propiedades y metodos en espanol usando camelCase.
- Clases con convencion estandar de Laravel y nombres explicitos.
- Comentarios en espanol, concretos y solo cuando agreguen contexto no obvio.
- Preferir codigo simple, legible y mantenible sobre abstracciones prematuras.
- Reutilizar componentes, acciones y servicios existentes antes de duplicar logica.

## Reglas arquitectonicas
- Controladores delgados; solo coordinan request, accion y respuesta.
- Validacion obligatoria en Form Requests.
- Logica de negocio en acciones o servicios por modulo.
- Efectos secundarios en eventos/listeners cuando desacoplan mejor el flujo.
- Jobs/queues solo para trabajo costoso o asincrono real.
- Evitar sobreingenieria: no agregar capas extra sin beneficio claro.
- Toda decision no obvia debe quedar explicada en documentacion.

## Reglas de frontend
- No redisenar la UI.
- Mantener maxima fidelidad visual en layout, textos, jerarquia, espaciados, colores e iconografia.
- Revisar siempre estados vacios, hover, foco, error, deshabilitado y responsive.
- Todo componente comun debe quedar alineado con la referencia antes de reutilizarse.

## Reglas de base de datos
- MySQL es el motor objetivo; SQLite solo puede usarse como apoyo local de pruebas si queda documentado.
- Definir relaciones, claves foraneas, indices y restricciones desde el inicio.
- Triggers solo si existe una necesidad real que no se resuelva mejor en aplicacion o con restricciones.
- Mantener `database/sql/esquemaCompleto.md` sincronizado con migraciones y `docs/baseDeDatos.md`.

## Reglas de seguridad
- Validar toda entrada de usuario.
- No exponer secretos, tokens ni credenciales en codigo, docs o logs.
- No mostrar errores sensibles al usuario final.
- Aplicar CSRF, autorizacion, escape de salida, manejo seguro de sesiones y rate limiting.
- Registrar acciones sensibles cuando aplique.

## Reglas de documentacion
- Actualizar `docs/levantamientoUi.md`, `docs/arquitectura.md`, `docs/modulos.md`, `docs/baseDeDatos.md`, `docs/seguridad.md`, `docs/librerias.md`, `docs/planImplementacion.md`, `docs/criteriosAceptacion.md`, `docs/convenciones.md`, `docs/despliegue.md` y `database/sql/esquemaCompleto.md` cuando el cambio lo requiera.
- Registrar cambios relevantes en `docs/cambios.md` con fecha, alcance y nota tecnica.
- Mantener codigo y documentacion sincronizados dentro de la misma tarea.

## Verificacion antes de cerrar una tarea importante
- Paridad visual validada contra referencia.
- Flujo funcional revisado de inicio a fin.
- Impacto arquitectonico revisado.
- Seguridad revisada.
- Pruebas minimas actualizadas o ejecutadas.
- Documentacion actualizada.
- Desviaciones registradas si existen.
