## Estructura del proyecto

```text
hola-mysql-compose/
├── docker-compose.yml
└── src/
    ├── Dockerfile
    └── index.php
```

## Servicios creados

- `app`: servidor web Apache con PHP.
- `db`: servidor de base de datos MySQL 8.0.

## Como ejecutarlo en GitHub Codespaces

1. Crear o abrir un repositorio en GitHub.
2. Entrar al repositorio y seleccionar `Code > Codespaces > Create codespace`.
3. Abrir una terminal dentro de Codespaces.
4. Entrar a la carpeta del proyecto:

```bash
cd hola-mysql-compose
```

5. Levantar los contenedores:

```bash
docker compose up --build
```

6. Abrir la aplicacion:

```text
http://localhost:8080
```

En Codespaces tambien puedes ir a la pestana `Ports`, buscar el puerto `8080` y abrirlo en el navegador.

## Comando para detener la practica

```bash
docker compose down
```

## Comando para borrar tambien la base de datos guardada

```bash
docker compose down -v
```

## Explicacion breve

El archivo `docker-compose.yml` define dos servicios. El servicio `app` construye una imagen usando el `Dockerfile` dentro de la carpeta `src` y publica la aplicacion en el puerto `8080`. El servicio `db` usa la imagen oficial de MySQL 8.0, crea una base de datos llamada `hola_mundo_db` y espera hasta estar saludable antes de que la aplicacion intente conectarse.

Cuando se abre la pagina, `index.php` se conecta a MySQL, crea una tabla llamada `visitas`, guarda una visita y muestra la cantidad de visitas registradas.
