<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
              <span class="navbar-brand">Usuarios</span>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <router-link class="nav-link" to="/">Lista</router-link>
                  </li>
                  <li class="nav-item">
                    <router-link class="nav-link" to="/registrar">Registrar</router-link>
                  </li>
                  <li class="nav-item">
                    <router-link class="nav-link" to="/configurarMail">Configurar Correo Administrador</router-link>
                  </li>
                </ul>
              </div>
            </div>
        </nav>
    </div>
</template>