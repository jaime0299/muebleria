<header>
        <div class="contenedor-nav"">
            <div class=" contenedor-logo-muebleria"><img class="logo-muebleria" src="img/logo_02.png" alt=""></div>
        <div class="contenedor-menu">
            <div class="menu-buttons">
                <div class="contenedor" id="uno">
                    <a href="Principal.php" style="text-decoration:none;" class="texto"><img class="icon" src="img/home.png">
                        <p class="texto" href="Principal.php">Inicio</p>
                    </a>
                </div>
		<?php
                if($sucursal!='Almacen'){?>
                <div class="contenedor" id="dos">
                    <a href="Venta.php" style="text-decoration:none;" class="texto"><img class="icon" src="img/caja.png">
                        <p class="texto" href="Venta.php">Venta</p>
                    </a>
                </div>
		<?php
                }?>
               <?php
                if($resultado[0]=='Matriz'){?>
                <div class="contenedor" id="tres">
                    <a href="Sucursales.php" style="text-decoration:none;" class="texto"><img class="icon" src="img/sucursal.png">
                        <p class="texto" href="Sucursales.php">Sucursales</p>
                    </a>
                </div>
                <?php
                }?>
                <div class="contenedor" id="cuatro">
                    <a href="entradas.php" style="text-decoration:none;" class="texto"><img class="icon" src="img/entrada.png">
                        <p class="texto" href="entradas.php">Entradas</p>
                    </a>
                </div>

                <div class="contenedor" id="cinco">
                    <a href="inventario.php" style="text-decoration:none;" class="texto"><img class="icon" src="img/inventario.png">
                        <p class="texto" href="inventario.php">Inventario</p>
                    </a>
                </div>
                <?php
                if($resultado[0]=='Matriz'){?>
                <div class="contenedor" id="seis">
                    <a href="Proveedores.php" style="text-decoration:none;" class="texto"><img class="icon" src="img/proveedor.png">
                        <p class="texto" href="Proveedores.php">Proveedores</p>
                    </a>
                </div>
                <?php
                }?>
                <div class="contenedor" id="siete">
                    <a href="Salir.php" style="text-decoration:none;" class="texto"><img class="icon" src="img/salir.png">
                        <p class="texto" href="Salir.php">Cerrar</p>
                    </a>
                </div>
            </div>
        </div>
        </div>
        <div class="barra-separadora"></div>
    </header>