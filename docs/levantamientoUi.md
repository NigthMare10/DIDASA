# Levantamiento UI

## Alcance visual levantado
- Pantallas identificadas: inicio, mis vehiculos, servicios, cotizar, agendar, mis ordenes y fidelidad.
- Patron visual dominante: encabezado claro, heroes oscuros, tarjetas blancas, CTA rojo intenso y tipografia sans corporativa.
- Jerarquia: titulos muy grandes, subtitulos grises amplios, tarjetas con icono superior y texto de apoyo corto.
- En fase de correccion visual se recalibro la escala tipografica, el sistema de contenedores y el comportamiento responsive para evitar reinterpretaciones del diseno.
- En esta fase fina se corrigio la navegacion para separar flujos principales (`Cotizar`, `Agendar`) de historiales (`Mis Cotizaciones`, `Mis Citas`) y se reforzo el comportamiento sticky/reactivo.

## Pantallas y componentes

### Inicio
- Navbar superior con logo, menu, campana, avatar y nombre del usuario.
- Hero principal oscuro con badge, titulo destacado, copy y dos CTAs.
- Franja de categorias: Motor, Frenos, Suspension, Electrico, A/C, Alineacion, Diagnostico.
- Seccion de beneficios con 6 tarjetas.
- Seccion "Como funciona" con 4 pasos.
- Bloque CTA oscuro y footer de 4 columnas.

### Mis Vehiculos
- Titulo, subtitulo, boton rojo para agregar vehiculo.
- Estado vacio con icono, mensaje y CTA secundario.
- Modal de alta con campos marca, modelo, anio, placa, vin, kilometraje y color.
- Estado con datos corregido para parecerse mas a la referencia: card compacta, CTA de carnet de salud y accion secundaria de eliminacion.
- Se agrego `Carnet de Salud` con vista detalle y exportacion PDF.

### Servicios
- Hero oscuro con titulo y subtitulo.
- Tabs visuales para `Servicios` y `Paquetes`.
- Estado vacio en ambas pestanas si no hay items visibles en catalogo.

### Cotizar
- La opcion principal de navbar `Cotizar` abre el flujo de `Nueva Cotizacion`.
- La vista principal ya no se comporta como historial; muestra formulario y resumen lateral sticky.
- `Mis Cotizaciones` se accede desde el menu de perfil y contiene el listado, badges y acciones aprobar/rechazar.
- El resumen lateral acompana el scroll en desktop con offset compatible con navbar sticky.

### Agendar
- La opcion principal de navbar `Agendar` abre el flujo de nueva cita, no el historial.
- El calendario cambia fecha en Alpine sin refrescar la pagina ni alterar la URL.
- El resumen de cita se actualiza de forma reactiva y queda sticky en desktop.
- `Mis Citas` se accede desde el menu de perfil con listado independiente.

### Mis Ordenes
- Hero oscuro.
- Estado vacio inicial.
- Vista funcional extendida con cards y timeline cuando existen ordenes.

### Fidelidad
- Navbar sticky translúcida sobre el contenido, sin hero oscuro.
- Tarjeta principal mas ancha y baja, columna lateral mas cercana a la referencia.
- Niveles del programa con cards compactas y mejor proporcion.
- Bloques `Insignias` y `Como ganar puntos` mas cercanos al layout de la referencia.

## Textos visibles clave
- "Tu vehiculo merece el mejor cuidado"
- "Todo lo que necesitas en un solo lugar"
- "Como funciona"
- "Mis Vehiculos"
- "Catalogo de Servicios"
- "Cotizacion Inteligente"
- "Agendar Cita"
- "Mis Ordenes de Trabajo"
- "Programa de Fidelidad"

## Colores aproximados
- Rojo principal: `#d90416`
- Fondo oscuro: `#1b2538`
- Fondo general: `#f5f6f8`
- Texto secundario: `#5e6878`
- Bordes suaves: `#d9dee7`

## Matriz de paridad visual
| Pantalla | Elementos identicos prioritarios | Diferencias tecnicas aceptadas |
|---|---|---|
| Inicio | Navbar, hero, categorias, cards, pasos, CTA, footer | Tipografia aproximada con Plus Jakarta Sans |
| Mis Vehiculos | Cabecera, CTA, cards, carnet y modal | Lista real de vehiculos mantenida por funcionalidad |
| Servicios | Hero, tabs, vacios | Cards si se publican items visibles |
| Cotizar | Flujo nuevo, resumen sticky, proporciones laterales | Historial movido a ruta separada del perfil |
| Agendar | Flujo nuevo, calendario reactivo, resumen sticky | Historial movido a ruta separada del perfil |
| Mis Ordenes | Hero y vacio | Lista/timeline visible cuando existan ordenes |
| Fidelidad | Layout, anchos de columnas, niveles, insignias, puntos | Datos calculados desde backend |

## Diferencias inevitables documentadas
- Se implemento vista con datos reales en `mis vehiculos` y `mis ordenes` para que el portal no quede solo con estados vacios.
- `servicios` permanece vacio por paridad visual; los servicios seeded se reservan para cotizacion y no se publican en catalogo por defecto.
- Se unifico el footer para todo el portal, ya que la referencia mantiene cierre visual consistente entre secciones.
- La validacion de overflow horizontal se hizo en escritorio amplio, laptop, tablet y movil con automatizacion en navegador sobre la implementacion local.
- El cambio de mes en agenda sigue consultando backend para disponibilidad real, pero ya no realiza refresh completo de pagina: ahora usa fetch + Alpine.
