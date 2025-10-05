# Multitenant - Gestion de Cursos y Estudiantes

## Descripcion

Sistema multitenant desarrollado en Laravel para la gestion de cursos y estudiantes de multiples universidades. Cada universidad (tenant) mantiene sus datos completamente aislados mediante un sistema basado en headers HTTP.

> **NOTA IMPORTANTE:** Este proyecto viene configurado con variables de entorno especificas para desarrollo local con Docker. Las credenciales de base de datos estan predefinidas para facilitar la instalacion y pruebas. Estaba pensando usar Azure Vault pero no me iba a poner a perder el tiempo en eso que no es tan importante para la prueba

## Requisitos del Sistema

- PHP 8.2 o superior
- Composer
- Docker y Docker Compose
- Git

## Instalacion

### 1. Clonar el repositorio

```bash
git clone https://github.com/alblandino/lacia
cd lacia
```

### 2. Instalar dependencias

```bash
composer install
```

### 3. Levantar base de datos con Docker

```bash
docker-compose up -d
```

### 4. Ejecutar migraciones y seeders

```bash
php artisan migrate --seed
```

### 5. Iniciar servidor de desarrollo

```bash
php artisan serve
```

La aplicacion estara disponible en: [http://localhost:8000](http://localhost:8000)

## Ejecutar Tests

```bash
php artisan test
```

Resultado esperado:
```
Tests:    8 passed (19 assertions)
Duration: < 1s
```

## 📊 Datos de Prueba

📋 **Toda la informacion sobre estructuras de base de datos, tenants, cursos, estudiantes y datos disponibles se encuentra en:** **[DATABASE.md](./DATABASE.md)**

## API Endpoints

**Base URL:** `http://localhost:8000/api`

**IMPORTANTE:** Todas las peticiones requieren el header `X-Tenant-ID`

### 1. Inscribir estudiante en curso

**POST** `/courses/{id}/enroll`

Headers:
```
Content-Type: application/json
X-Tenant-ID: 1
```

Body:
```json
{
  "student_id": 4
}
```

### 2. Obtener estudiantes de un curso

**GET** `/courses/{id}/students`

Headers:
```
X-Tenant-ID: 1
```

## Coleccion de Postman

Importar el archivo **postman_collection.json** incluido en el proyecto.

Variables a configurar:
- `tenant_id`: `1` (UASD) o `2` (PUCMM)

## Casos Exitosos

### 1. Inscripcion exitosa

```bash
curl -X POST http://localhost:8000/api/courses/1/enroll \
  -H "Content-Type: application/json" \
  -H "X-Tenant-ID: 1" \
  -d '{"student_id": 4}'
```

> Respuesta: `201 Created`

```json
{
  "message": "Estudiante registrado exitosamente",
  "data": {
    "id": 1,
    "course_id": 1,
    "student_id": 4,
    "enrolled_at": "2024-10-04T12:00:00.000000Z"
  }
}
```

### 2. Consultar estudiantes

```bash
curl -X GET http://localhost:8000/api/courses/1/students \
  -H "X-Tenant-ID: 1"
```

> Respuesta: `200 OK`

```json
{
  "data": [
    {
      "id": 1,
      "name": "Juan Carlos Pérez",
      "email": "juan.perez@uasd.edu.do"
    }
  ]
}
```

## Casos de Error

### 1. Falta header X-Tenant-ID

```bash
curl -X POST http://localhost:8000/api/courses/1/enroll \
  -H "Content-Type: application/json" \
  -d '{"student_id": 4}'
```

Respuesta: `400 Bad Request`
```json
{
  "error": "Tenant ID obligatorio",
  "message": "Por favor proporciona el header X-Tenant-ID"
}
```

### 2. Curso inactivo

```bash
curl -X POST http://localhost:8000/api/courses/3/enroll \
  -H "Content-Type: application/json" \
  -H "X-Tenant-ID: 1" \
  -d '{"student_id": 4}'
```

> Respuesta: `422 Unprocessable Entity`

```json
{
  "error": "Curso inactivo",
  "message": "Curso con ID 3 no esta activo."
}
```

### 3. Inscripcion duplicada

```bash
# Primera inscripcion (exitosa)
curl -X POST http://localhost:8000/api/courses/1/enroll \
  -H "Content-Type: application/json" \
  -H "X-Tenant-ID: 1" \
  -d '{"student_id": 4}'

# Segunda inscripcion (falla)
curl -X POST http://localhost:8000/api/courses/1/enroll \
  -H "Content-Type: application/json" \
  -H "X-Tenant-ID: 1" \
  -d '{"student_id": 4}'
```

> Respuesta: `409 Conflict`

```json
{
  "error": "Ya esta registrado",
  "message": "Estudiante con ID 4 ya esta inscrito en curso con ID 1."
}
```

### 4. Aislamiento de tenants

```bash
curl -X POST http://localhost:8000/api/courses/5/enroll \
  -H "Content-Type: application/json" \
  -H "X-Tenant-ID: 1" \
  -d '{"student_id": 1}'
```

> Respuesta: `404 Not Found`

```json
{
  "error": "Curso no encontrado",
  "message": "Curso con ID 5 no encontrado."
}
```

__Nota:__ El curso ID 5 pertenece a PUCMM (Tenant 2).

### 5. Estudiante inexistente

```bash
curl -X POST http://localhost:8000/api/courses/1/enroll \
  -H "Content-Type: application/json" \
  -H "X-Tenant-ID: 1" \
  -d '{"student_id": 999}'
```

> Respuesta: `404 Not Found`

```json
{
  "error": "Estudiante no encontrado",
  "message": "Estudiante con ID 999 no encontrado."
}
```

## Codigos de Respuesta

| Codigo | Descripcion | Cuando ocurre |
|---|---|---|
| 200 | OK | Consulta exitosa |
| 201 | Created | Inscripcion exitosa |
| 400 | Bad Request | Falta header X-Tenant-ID |
| 404 | Not Found | Curso/estudiante no encontrado |
| 409 | Conflict | Estudiante ya inscrito |
| 422 | Unprocessable Entity | Curso inactivo |

### Testing

```bash
# Ejecutar todas las pruebas
php artisan test

# Limpiar cache de las pruebas
php artisan cache:clear
php artisan config:clear
```