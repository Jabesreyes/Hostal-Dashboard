# Hostal-Dashboard
# Hostal Carolinas Dashboard

Este repositorio contiene el código fuente del sistema de gestión para Hostal Carolinas. La aplicación está desarrollada en PHP utilizando Laravel como framework principal y MySQL como base de datos. El sistema permite gestionar reservas, clientes y control financiero de manera centralizada.

## Requisitos Previos

Antes de comenzar, asegúrate de tener instalado lo siguiente:
- PHP >= 8.0
- Composer
- Node.js y npm
- MySQL

## Instrucciones para la Clonación y Configuración

Sigue los siguientes pasos para clonar y configurar el proyecto en tu entorno de desarrollo o producción.

### 1. Clonar el Repositorio

Clona el repositorio desde GitHub:

```bash
git clone https://github.com/Jabesreyes/Hostal-Dashboard.git
cd Hostal-Dashboard
```
### 2. Configurar el entorno de Laravel

##### 1.Instalar dependencias de PHP
``` bash
composer install

```
#### 2. Configurar el archivo .env
``` bash
    cp .env.example .env
```
#### 3. Generar la clave de la aplicación
``` bash
php artisan key:generate
```
#### 4. Ejecutar las migraciones
``` bash
php artisan migrate
```
#### 5. Ejecutar los Seeders
``` bash
php artisan db:seed
```

### 3. Configurar el entorno de Node.js

##### 1.Instalar dependencias de Node.js
``` bash
npm install

```
#### 2. Compilar los assets de front-end
``` bash
npm run dev    
npm run build  
```

### 4. Iniciar el servidor de Laravel

##### 1. Usar el servidor
``` bash
php artisan serve

```
