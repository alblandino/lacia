# Datos de la base de datos para pruebas

## Tenants (Universidades)

| ID | Nombre | Subdominio |
|----|--------|-----------|
| 1  | Universidad Autonoma de Santo Domingo | uasd |
| 2  | Pontificia Universidad Catolica Madre y Maestra | pucmm |

---

## TENANT 1 - UASD (tenant_id: 1)

### Cursos

| ID | Nombre | Estado | Descripcion |
|----|--------|--------|-------------|
| 1  | Programacion I | active | Introduccion a la programacion con Python |
| 2  | Base de Datos | active | Diseño y gestion de bases de datos relacionales |
| 3  | Matematicas Discretas | **inactive** | Fundamentos matematicos para ciencias de la computacion |
| 4  | Algoritmos y Estructuras de Datos | active | Estudio de algoritmos eficientes y estructuras de datos |

### Estudiantes

| ID | Nombre | Correo |
|----|--------|-------|
| 1  | Juan Carlos Perez | juan.perez@uasd.edu.do |
| 2  | Maria Rodriguez | maria.rodriguez@uasd.edu.do |
| 3  | Pedro Garcia | pedro.garcia@uasd.edu.do |
| 4  | Ana Martinez | ana.martinez@uasd.edu.do |
| 5  | Luis Fernandez | luis.fernandez@uasd.edu.do |

### Inscripciones ya registradas

| Estudiante | Curso |
|------------|-------|
| Juan Carlos Perez (1) | Programacion I (1) |
| Juan Carlos Perez (1) | Base de Datos (2) |
| Maria Rodriguez (2) | Programacion I (1) |
| Pedro Garcia (3) | Base de Datos (2) |
| Pedro Garcia (3) | Algoritmos y Estructuras de Datos (4) |

**Estudiantes disponibles para inscribir:**
- ✅ Ana Martinez (4) - No tiene registris
- ✅ Luis Fernandez (5) - No tiene registros

---

## TENANT 2 - PUCMM (tenant_id: 2)

### Cursos

| ID | Nombre | Estado | Descripcion |
|----|--------|--------|-------------|
| 5  | Desarrollo Web | active | Desarrollo de aplicaciones web modernas |
| 6  | Ingenieria de Software | active | Metodologias y practicas de desarrollo de software |
| 7  | Inteligencia Artificial | **inactive** | Fundamentos de IA y Machine Learning |
| 8  | Redes de Computadoras | active | Arquitectura y protocolos de redes |

### Estudiantes

| ID | Nombre | Correo |
|----|--------|-------|
| 6  | Carlos Sanchez | carlos.sanchez@pucmm.edu.do |
| 7  | Sofia Lopez | sofia.lopez@pucmm.edu.do |
| 8  | Miguel Torres | miguel.torres@pucmm.edu.do |
| 9  | Isabella Ramirez | isabella.ramirez@pucmm.edu.do |
| 10 | Jose Vargas | jose.vargas@pucmm.edu.do |

### Inscripciones ya registradas

| Estudiante | Curso |
|------------|-------|
| Carlos Sanchez (6) | Desarrollo Web (5) |
| Carlos Sanchez (6) | Ingenieria de Software (6) |
| Sofia Lopez (7) | Desarrollo Web (5) |
| Sofia Lopez (7) | Redes de Computadoras (8) |
| Miguel Torres (8) | Ingenieria de Software (6) |

**Estudiantes disponibles para inscribir:**
- ✅ Isabella Ramirez (9) - No tiene registros
- ✅ Jose Vargas (10) - No tiene registros