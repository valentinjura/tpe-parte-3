<?php
  require_once 'config.php';
    class Model {
        protected $db;
 
        function __construct() {
          $this->db = new PDO('mysql:host='. MYSQL_HOST.';charset=utf8', MYSQL_USER, MYSQL_PASS);
          if($this->db){
            $this->createDatabaseSiNoExiste();
            $this->db->exec('USE ' . MYSQL_DB);
            $this->deploy();
          }
          
        }

      function createDatabaseSiNoExiste() {
          $databaseName = MYSQL_DB;
          $query = "CREATE DATABASE IF NOT EXISTS `$databaseName` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
          $this->db->exec($query);
          
      }

        function deploy() {
            $query = $this->db->query('SHOW TABLES');
            $tables = $query->fetchAll();

            $w3OUohfKw28vCSrxTHN0Su7dk1xGIJZ='$w3OUohfKw28vCSrxTHN0Su7dk1xGIJZ';
            
            if(count($tables)==0) {
              $sql =<<<END
              
              --
              -- Estructura de tabla para la tabla `categorias`
              --

              CREATE TABLE `categorias` (
                `categoriaID` int(11) NOT NULL,
                `nombre` varchar(255) NOT NULL
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

              --
              -- Volcado de datos para la tabla `categorias`
              --

              INSERT INTO `categorias` (`categoriaID`, `nombre`) VALUES
              (1, 'Electronica'),
              (2, 'Hogar'),
              (3, 'Indumentaria');

              -- --------------------------------------------------------

              --
              -- Estructura de tabla para la tabla `productos`
              --

              CREATE TABLE `productos` (
                `id` int(11) NOT NULL,
                `categoriaID` int(200) NOT NULL,
                `producto` varchar(200) NOT NULL,
                `precio` double NOT NULL,
                `stock` tinyint(1) NOT NULL DEFAULT 1
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

              --
              -- Volcado de datos para la tabla `productos`
              --

              INSERT INTO `productos` (`id`, `categoriaID`, `producto`, `precio`, `stock`) VALUES
              (1, 3, 'Sofá', 50, 1),
              (2, 1, 'computadora', 500, 1),
              (3, 3, 'Remera', 8, 1),
              (4, 3, 'Pantalon', 12, 1),
              (5, 2, 'Silla', 15, 1),
              (13, 1, 'TV', 1000, 1);

              -- --------------------------------------------------------

              --
              -- Estructura de tabla para la tabla `users`
              --

              CREATE TABLE `users` (
                `id` int(11) NOT NULL,
                `user` varchar(250) NOT NULL,
                `password` varchar(250) NOT NULL
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

              --
              -- Volcado de datos para la tabla `users`
              --

              INSERT INTO `users` (`id`, `user`, `password`) VALUES
              (0, 'webadmin', '$2y$10$w3OUohfKw28vCSrxTHN0Su7dk1xGIJZ.xQ8G6gyHQp2yta.Sp66/S');

              --
              -- Índices para tablas volcadas
              --

              --
              -- Indices de la tabla `categorias`
              --
              ALTER TABLE `categorias`
                ADD PRIMARY KEY (`categoriaID`);

              --
              -- Indices de la tabla `productos`
              --
              ALTER TABLE `productos`
                ADD PRIMARY KEY (`id`),
                ADD KEY `categoriaID` (`categoriaID`);

              --
              -- Indices de la tabla `users`
              --
              ALTER TABLE `users`
                ADD PRIMARY KEY (`id`);

              --
              -- AUTO_INCREMENT de las tablas volcadas
              --

              --
              -- AUTO_INCREMENT de la tabla `categorias`
              --
              ALTER TABLE `categorias`
                MODIFY `categoriaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

              --
              -- AUTO_INCREMENT de la tabla `productos`
              --
              ALTER TABLE `productos`
                MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

              --
              -- Restricciones para tablas volcadas
              --

              --
              -- Filtros para la tabla `productos`
              --
              ALTER TABLE `productos`
                ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoriaID`) REFERENCES `categorias` (`CategoriaID`);
              COMMIT;
              END;
              $this->db->query($sql);
          }
        }
    }