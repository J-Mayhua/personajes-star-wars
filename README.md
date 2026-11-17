# Sistema de Gestión de Personajes Star Wars

## Información del Candidato

Nombre: Jose Adolfo Mayhua Palomino
Email: joseadolfomayhua01@gmail.com
Teléfono: 925758041

## Requisitos del Sistema

- PHP 8.1+
- Composer
- Node.js 18+
- MySQL 8+ (se puede levantar con Docker, ver paso 4)

## Instalación

1. Clonar repositorio

```bash
git clone https://github.com/J-Mayhua/personajes-star-wars
cd personajes-star-wars
```

2. Instalar dependencias

```bash
composer install
npm install
```

3. Configurar base de datos

```bash
cp .env.example .env
```

Edita `.env` si tus credenciales de MySQL son distintas a las de `.env.example`.

```bash
php artisan key:generate
```

4. Levantar MySQL y ejecutar migraciones

```bash
docker run -d --name mysql-mau -e MYSQL_ROOT_PASSWORD=root -e MYSQL_DATABASE=personajes -p 3306:3306 mysql:8
```

MySQL tarda entre 20 y 30 segundos en estar listo. Espera antes de continuar. Si el contenedor ya existe, inícialo con `docker start mysql-mau`.

```bash
php artisan migrate
```

5. Compilar assets

```bash
npm run build
```

`npm run build` compila los assets para producción. Para desarrollo con recarga automática se puede usar `npm run dev`.

6. Iniciar servidor

```bash
php artisan serve
```

7. Acceder

http://localhost:8000/personajes

## Funcionalidades Implementadas

Obligatorias:

- CRUD completo de personajes
- Integración con SWAPI
- Validaciones backend (Form Requests) y frontend (atributos HTML)
- Paginación de 10 por página
- Componentes Vue reutilizables
- Diseño responsive
- Mensajes de éxito y error visibles

Bonus:

- Service Layer (`app/Services/PersonajeService.php`)

## Tecnologías

- Laravel 12.72.0 (PHP 8.2.12)
- Vue.js [COMPLETAR: versión de `npm ls vue`]
- Inertia.js (cliente `@inertiajs/vue3` 2.3.29 y adaptador `inertiajs/inertia-laravel` 2.0.28)
- Tailwind CSS [COMPLETAR: versión de `npm ls tailwindcss`]
- Vite 7.3.8
- MySQL 8 (Docker)
- Node.js 24.11.0

No se usó ningún starter kit: el proyecto se creó con `laravel new` y Inertia se instaló manualmente.

## Notas

1. **Masa mayor a 500 en SWAPI.** Algunos personajes superan el máximo de 500 que pide la validación del formulario (por ejemplo, Jabba, ID 16, con masa 1358). Al importar se guarda el valor real de SWAPI. Al editar ese personaje, la validación pedirá corregir la masa. Es una decisión consciente para no alterar los datos de origen.
2. **`planeta_origen` queda vacío al importar.** SWAPI devuelve una URL del planeta (`homeworld`) y el mapeo del enunciado no incluye ese campo.
3. **Transformación de datos.** `"unknown"` y cualquier valor no numérico pasan a `null`, se quitan las comas de miles (por ejemplo, `"1,358"`) y cualquier género distinto de `male` o `female` pasa a `n/a`.
4. **Errores de SWAPI.** Se manejan el timeout de 10 segundos, el ID inexistente (404) y la API caída u otros fallos. Los mensajes se muestran dentro del modal de importación. Si SWAPI está caído, el resto de la aplicación sigue funcionando y solo falla la importación.
5. **Duplicados y rango.** El rango de IDs (1 a 83) y el rechazo de un `swapi_id` repetido se validan antes de consultar la API. La columna `swapi_id` también es única en la base de datos.

## Decisiones Técnicas

### 1. Organización del código backend

Mantuve el controlador simple: recibe la petición, delega y devuelve la respuesta. Las validaciones están en dos Form Requests (`PersonajeRequest` para crear y actualizar, e `ImportarPersonajeRequest` para importar). La lógica de SWAPI está en un Service (`PersonajeService`), que consulta la API, maneja los errores, transforma los datos y crea el personaje. El modelo solo define los campos permitidos y el cast booleano. Así cada archivo tiene una sola responsabilidad y es fácil de modificar. Las rutas están declaradas una por una en `routes/web.php`, tal cual el enunciado.

### 2. Componentes Vue

Creé `PersonajeForm` (el mismo formulario sirve para crear y editar), `PersonajeTable` (tabla en escritorio y cards en móvil), `Pagination`, `ImportModal`, `CampoFormulario` (etiqueta, input y error de cada campo) y `AppLayout` (barra superior y mensajes). Son reutilizables porque reciben los datos por props, no dependen de una página concreta y cada uno hace una sola cosa. Por ejemplo, `PersonajeForm` se usa en Crear y en Editar sin repetir código, y `CampoFormulario` evita repetir el mismo bloque en cada campo.

### 3. Manejo de errores de SWAPI

La consulta tiene un tiempo máximo de 10 segundos. Si no hay conexión o la API está caída, se muestra un mensaje de conexión. Si el ID no existe (404), se avisa que ese ID no existe en SWAPI. Si responde con otro error, se informa que SWAPI no está disponible, junto con el código. El servicio lanza una excepción con un mensaje claro, el controlador la captura y la devuelve como error del campo, y el modal la muestra sin romper la aplicación. El rango 1-83 y los duplicados se validan antes de llamar a la API.

### 4. Validaciones

Las implementé en el backend con Form Requests, porque es la validación que realmente cuenta: la del navegador se puede saltar. Además, las mismas reglas se reutilizan al crear y al actualizar, y el controlador queda limpio. En el frontend agregué validación básica con atributos HTML (`required`, `min`, `max`, `minlength`, `maxlength`) para dar respuesta rápida, y se muestran los errores que devuelve el backend debajo de cada campo.

### 5. Mayor dificultad

Lo más difícil fue un conflicto entre dos requisitos del enunciado. La validación del formulario permite una masa máxima de 500 kg, pero SWAPI trae personajes con valores mayores (por ejemplo, Jabba tiene 1358). Lo descubrí al probar: la importación guardaba bien el dato, pero al editar a Jabba el formulario rechazaba el guardado hasta que se bajara la masa.

Consideré cuatro opciones: recortar la masa a 500, guardarla vacía, subir el límite del formulario o dejar el dato real. Elegí dejar el dato real de SWAPI y mantener el límite de 500 que pide el enunciado, porque recortar o borrar el valor alteraría la información de origen, y cambiar el límite incumpliría el requisito. Lo dejé documentado en las Notas. Como mejora futura, la validación podría relajarse solo para los personajes importados.

### 6. Uso de Inteligencia Artificial

Sí. Usé Claude como guía y tutor: para planificar la arquitectura, ordenar el proyecto por fases, resolver errores de instalación y revisar mi código. El código lo escribió un agente de IA (DeepSeek, modelo Flash, desde opencode) por fases, siguiendo una especificación basada en el enunciado.

Yo hice la instalación y la configuración (Laravel, Inertia, Vue, Tailwind y MySQL en Docker), leí cada archivo generado, probé cada fase a mano (crear, editar, eliminar, paginar e importar con distintos casos), probé el servicio de SWAPI con `tinker` (ID válido, ID inexistente y valores como la masa 1358), verifiqué que `npm run build` pasara sin errores y hice un commit por fase. Solo avancé a la siguiente fase cuando entendí lo que hacía cada parte.

### 7. Mejoras futuras

- Guardar el nombre del planeta consultando la URL de `homeworld` de SWAPI.
- Relajar el límite de masa solo para personajes importados.
- Pruebas automáticas del servicio y de las rutas.
- Búsqueda en tiempo real por nombre y filtro por género.
- Docker Compose para levantar la aplicación y MySQL juntos.
- Seeders con datos de prueba.
- Soft deletes y un comando de Artisan para importar varios personajes.

### 8. Autoevaluación

Me daría un 7 sobre 10. Lo mejor de mi solución es que todo lo obligatorio funciona, el código está ordenado por responsabilidades, el manejo de errores de SWAPI es claro y la interfaz es responsive. Lo que mejoraría son las pruebas automáticas y el planeta de origen.

### 9. Tiempo invertido

Aproximadamente 7 horas, contando instalación, desarrollo por fases, pruebas y documentación.
