# Sistema de Votación CEPEA 2025

## Descripción
Sistema completo de votación para el Centro Preuniversitario de Educación Avanzada (CEPEA) que permite registro estudiantil, autenticación, votación y consulta de resultados.

## Características
- ✅ Registro de estudiantes con generación automática de códigos
- ✅ Sistema de autenticación seguro con sesiones
- ✅ Prevención de votos duplicados
- ✅ Interfaz responsive y moderna
- ✅ Gestión de resultados en tiempo real
- ✅ Panel administrativo para ver lista de votos
- ✅ Base de datos estructurada con relaciones

## Archivos del Sistema

### Archivos Principales
- `index.html` - Página principal del sistema
- `conexion_pdo.php` - Configuración de conexión a base de datos (mysqli + PDO)
- `config_sesion.php` - Configuración de sesiones y funciones auxiliares

### Registro y Autenticación
- `registro.html` - Formulario de registro estudiantil
- `registro.php` - Procesamiento del registro
- `registro_exitoso.html` - Confirmación de registro exitoso
- `login.html` - Formulario de inicio de sesión
- `login.php` - Procesamiento del login

### Votación
- `votar.html` - Interfaz de votación
- `votar.php` - Procesamiento del voto
- `voto_confirmado.html` - Confirmación de voto emitido

### Administración
- `lista.php` - Lista de votos (panel administrativo)
- `eliminar.php` - Eliminación de votos
- `resultados.php` - Resultados oficiales con estadísticas

## Configuración de Base de Datos

### 1. Crear Base de Datos
Ejecuta el script `database_setup.sql` en tu servidor MySQL:

```sql
mysql -u root -p < database_setup.sql
```

### 2. Configurar Conexión
Edita `conexion_pdo.php` con tus credenciales:

```php
$servidor = "localhost";
$usuario = "root";        // Tu usuario MySQL
$clave = "";              // Tu contraseña MySQL
$basedatos = "sistema_votacion_cepea";
```

### 3. Estructura de Tablas

#### Tabla `estudiantes`
- `id` (INT, AUTO_INCREMENT, PRIMARY KEY)
- `nombre` (VARCHAR 255)
- `identificacion` (VARCHAR 50, UNIQUE)
- `codigo_estudiante` (VARCHAR 50, UNIQUE)
- `contrasena_hash` (VARCHAR 255)
- `fecha_registro` (TIMESTAMP)
- `activo` (BOOLEAN)

#### Tabla `votos`
- `id` (INT, AUTO_INCREMENT, PRIMARY KEY)
- `estudiante_id` (INT, FOREIGN KEY)
- `candidato_elegido` (VARCHAR 100)
- `fecha_voto` (TIMESTAMP)
- `UNIQUE KEY unique_voto_estudiante` (estudiante_id)

#### Tabla `candidatos`
- `id` (INT, AUTO_INCREMENT, PRIMARY KEY)
- `clave_voto` (VARCHAR 100, UNIQUE)
- `nombre` (VARCHAR 255)
- `carrera` (VARCHAR 100)
- `activo` (BOOLEAN)

## Instalación

### Requisitos
- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache/Nginx)

### Pasos de Instalación
1. **Descargar archivos**: Coloca todos los archivos en tu directorio web
2. **Base de datos**: Ejecuta `database_setup.sql`
3. **Configuración**: Edita `conexion_pdo.php` con tus credenciales
4. **Permisos**: Asegúrate de que PHP tenga permisos de escritura
5. **Acceso**: Navega a `http://tu-servidor/index.html`

## Uso del Sistema

### Para Estudiantes
1. **Registro**: Accede a "Registro Estudiantil" y completa el formulario
2. **Código**: Guarda tu código de estudiante generado
3. **Votación**: Usa tu código y contraseña para iniciar sesión
4. **Voto**: Selecciona tu candidato y confirma tu voto

### Para Administradores
1. **Lista de votos**: Accede a "Lista de Votos (Admin)"
2. **Resultados**: Consulta "Ver Resultados" para estadísticas
3. **Gestión**: Elimina votos incorrectos si es necesario

## Candidatos Predefinidos
- Raúl Pineda (Administración)
- María Palacios (Sistemas)
- Jorge Choque (Enfermería)

## Seguridad
- ✅ Contraseñas hasheadas con `password_hash()`
- ✅ Consultas preparadas (Prepared Statements)
- ✅ Sesiones seguras con validación
- ✅ Prevención de inyección SQL
- ✅ Validación de datos de entrada
- ✅ Prevención de votos duplicados

## Solución de Problemas

### Error de Conexión a BD
- Verifica credenciales en `conexion_pdo.php`
- Confirma que la base de datos existe
- Asegúrate de que MySQL esté ejecutándose

### Errores de Sesión
- Verifica que `config_sesion.php` se incluya correctamente
- Confirma permisos de escritura en directorio de sesiones

### Problemas de Votación
- Verifica que las tablas estén creadas correctamente
- Confirma que los candidatos estén insertados

## Personalización

### Agregar Candidatos
Inserta nuevos candidatos en la tabla `candidatos`:

```sql
INSERT INTO candidatos (clave_voto, nombre, carrera) 
VALUES ('nueva_clave', 'Nombre Completo', 'Carrera');
```

### Modificar Estilos
Edita los archivos CSS en las etiquetas `<style>` de cada archivo HTML.

### Agregar Validaciones
Utiliza las funciones de `config_sesion.php` para agregar validaciones adicionales.

## Soporte
Para soporte técnico o consultas, contacta al administrador del sistema.

## Licencia
Este sistema es desarrollado para uso exclusivo de CEPEA.

---
**© 2025 CEPEA - Sistema de Votación Seguro**# Sistema-de-votacion
