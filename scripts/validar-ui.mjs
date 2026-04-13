import fs from 'node:fs';
import path from 'node:path';
import { chromium } from 'playwright';

const baseUrl = 'http://127.0.0.1:8001';
const directorioCapturas = path.resolve('storage/app/ui-validacion');

fs.mkdirSync(directorioCapturas, { recursive: true });

const browser = await chromium.launch({ headless: true });
const context = await browser.newContext({ baseURL: baseUrl });
const page = await context.newPage();

async function iniciarSesion() {
    await page.goto('/login', { waitUntil: 'networkidle' });
    await page.locator('input[name="email"]').fill('cesar@didasa.test');
    await page.locator('input[name="password"]').fill('password');
    await page.getByRole('button', { name: 'Ingresar' }).click();
    await page.waitForLoadState('networkidle');
}

async function asegurarVehiculo() {
    await page.goto('/mis-vehiculos', { waitUntil: 'networkidle' });

    if (await page.getByText('Sin vehiculos registrados').count()) {
        const sufijo = Date.now().toString().slice(-5);
        await page.getByRole('button', { name: 'Agregar Vehiculo' }).first().click();
        await page.locator('input[name="marca"]').fill('Toyota');
        await page.locator('input[name="modelo"]').fill('Hilux');
        await page.locator('input[name="anio"]').fill('2024');
        await page.locator('input[name="placa"]').fill(`UI-${sufijo}`);
        await page.locator('input[name="vin"]').fill(`VIN${sufijo}2026`);
        await page.locator('input[name="kilometraje"]').fill('6200');
        await page.locator('input[name="color"]').fill('Blanco');
        await page.getByRole('button', { name: 'Registrar Vehiculo' }).click();
        await page.waitForLoadState('networkidle');
    }

    return await page.getByRole('link', { name: /Carnet de Salud/i }).first().getAttribute('href');
}

async function crearCotizacionSiFalta() {
    await page.goto('/mis-cotizaciones', { waitUntil: 'networkidle' });

    if (await page.getByText('Cotizacion #').count()) {
        return;
    }

    await page.goto('/cotizar', { waitUntil: 'networkidle' });

    await page.locator('select[name="vehiculoId"]').selectOption({ index: 1 });
    await page.locator('select').nth(1).selectOption({ index: 1 });
    await page.getByRole('button', { name: /^Agregar$/ }).first().click();
    await page.getByRole('button', { name: 'Enviar Cotizacion' }).click();
    await page.waitForLoadState('networkidle');
}

async function crearCitaSiFalta() {
    await page.goto('/mis-citas', { waitUntil: 'networkidle' });

    if (await page.locator('article').count()) {
        return;
    }

    await page.goto('/agendar', { waitUntil: 'networkidle' });

    await page.locator('select[name="vehiculoId"]').selectOption({ index: 1 });
    const fechaDisponible = page.locator('button[data-fecha][data-disponible="true"][data-seleccionado="false"]').first();
    await fechaDisponible.click();
    await page.locator('button[data-hora]').first().click();
    await page.getByRole('button', { name: 'Confirmar Cita' }).click();
    await page.waitForLoadState('networkidle');
}

async function validarNavegacionPrincipal() {
    await page.goto('/cotizar', { waitUntil: 'networkidle' });
    await page.getByRole('heading', { name: 'Cotización Inteligente' }).waitFor();

    await page.goto('/agendar', { waitUntil: 'networkidle' });
    await page.getByRole('heading', { name: 'Agendar Cita' }).waitFor();

    await page.goto('/mis-cotizaciones', { waitUntil: 'networkidle' });
    if (await page.locator('a.navegacion-item-activo').filter({ hasText: 'Cotizar' }).count()) {
        throw new Error('Cotizar aparece activo dentro de Mis Cotizaciones.');
    }

    await page.goto('/mis-citas', { waitUntil: 'networkidle' });
    if (await page.locator('a.navegacion-item-activo').filter({ hasText: 'Agendar' }).count()) {
        throw new Error('Agendar aparece activo dentro de Mis Citas.');
    }
}

async function validarNavbarStickyYTranslucida(ruta) {
    await page.goto(ruta, { waitUntil: 'networkidle' });

    const header = page.locator('header').first();
    const antes = await header.boundingBox();
    await page.evaluate(() => window.scrollTo(0, 700));
    await page.waitForTimeout(250);
    const despues = await header.boundingBox();

    if (!antes || !despues || Math.abs(despues.y) > 1) {
        throw new Error(`La navbar no permanece fija en ${ruta}.`);
    }

    const estilos = await page.evaluate(() => {
        const header = document.querySelector('header');
        const estilos = window.getComputedStyle(header);
        return {
            backdropFilter: estilos.backdropFilter,
            backgroundColor: estilos.backgroundColor,
        };
    });

    if (estilos.backdropFilter === 'none' || !estilos.backgroundColor.startsWith('rgba(')) {
        throw new Error(`La navbar no tiene translucidez/blur válida en ${ruta}.`);
    }

    await page.evaluate(() => window.scrollTo(0, 0));
}

async function validarResumenSticky(ruta, tituloResumen) {
    await page.goto(ruta, { waitUntil: 'networkidle' });
    await page.setViewportSize({ width: 1366, height: 900 });

    const resumen = page.getByText(tituloResumen).locator('..').first();
    const antes = await resumen.boundingBox();
    await page.evaluate(() => window.scrollTo(0, 900));
    await page.waitForTimeout(250);
    const despues = await resumen.boundingBox();

    if (!antes || !despues || despues.y > 160) {
        throw new Error(`El bloque ${tituloResumen} no se mantiene sticky en ${ruta}.`);
    }

    await page.evaluate(() => window.scrollTo(0, 0));
}

async function validarCalendarioSinRefresh() {
    await page.goto('/agendar', { waitUntil: 'networkidle' });
    await page.locator('select[name="vehiculoId"]').selectOption({ index: 1 });

    const urlAntes = page.url();
    const botonDia = page.locator('button[data-fecha][data-disponible="true"][data-seleccionado="false"]').first();
    const textoAntes = await page.locator('aside dd').nth(1).textContent();
    await botonDia.click();
    await page.waitForTimeout(300);
    const urlDespues = page.url();
    const textoDespues = await page.locator('aside dd').nth(1).textContent();

    if (urlAntes !== urlDespues) {
        throw new Error('La seleccion de fecha en Agendar esta refrescando o cambiando la URL.');
    }

    if (textoAntes === textoDespues) {
        throw new Error('La seleccion de fecha no actualizo el resumen de cita.');
    }
}

function slug(ruta) {
    const rutaNormalizada = ruta.startsWith('http') ? new URL(ruta).pathname : ruta;

    return rutaNormalizada === '/' ? 'inicio' : rutaNormalizada.replaceAll('/', '-').replace(/^-/, '');
}

await iniciarSesion();
const rutaCarnet = await asegurarVehiculo();
await crearCotizacionSiFalta();
await crearCitaSiFalta();
await validarNavegacionPrincipal();
await validarCalendarioSinRefresh();
for (const rutaSticky of ['/', '/servicios', '/cotizar', '/agendar', '/mis-vehiculos', '/fidelidad', '/mis-ordenes', '/mis-cotizaciones', '/mis-citas', rutaCarnet]) {
    await validarNavbarStickyYTranslucida(rutaSticky);
}
await validarResumenSticky('/cotizar', 'Resumen');
await validarResumenSticky('/agendar', 'Resumen de Cita');

const breakpoints = [
    { nombre: 'desktop-amplio', width: 1600, height: 1200 },
    { nombre: 'laptop', width: 1366, height: 900 },
    { nombre: 'tablet', width: 1024, height: 768 },
    { nombre: 'movil', width: 390, height: 844 },
];

const rutas = ['/', '/servicios', '/cotizar', '/agendar', '/mis-vehiculos', '/fidelidad', '/mis-cotizaciones', '/mis-citas', rutaCarnet].filter(Boolean);
const resultados = [];

for (const breakpoint of breakpoints) {
    await page.setViewportSize({ width: breakpoint.width, height: breakpoint.height });

    for (const ruta of rutas) {
        await page.goto(ruta, { waitUntil: 'networkidle' });
        const overflow = await page.evaluate(() => ({
            html: document.documentElement.scrollWidth - window.innerWidth,
            body: document.body.scrollWidth - window.innerWidth,
        }));

        resultados.push({ breakpoint: breakpoint.nombre, ruta, overflow });

        if (overflow.html > 1 || overflow.body > 1) {
            throw new Error(`Overflow horizontal detectado en ${ruta} (${breakpoint.nombre}) -> html:${overflow.html}, body:${overflow.body}`);
        }

        await page.screenshot({ path: path.join(directorioCapturas, `${breakpoint.nombre}-${slug(ruta)}.png`), fullPage: true });
    }
}

console.table(resultados.map((resultado) => ({
    breakpoint: resultado.breakpoint,
    ruta: resultado.ruta,
    overflowHtml: resultado.overflow.html,
    overflowBody: resultado.overflow.body,
})));

await browser.close();
