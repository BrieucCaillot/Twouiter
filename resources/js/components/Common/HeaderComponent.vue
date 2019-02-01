<template>
    <header class="over-hide">
        <nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
            <div class="container">
                <div class="navbar-brand">
                    <a class="navbar-item">
                        <img src="images/twitter.png">
                    </a>

                    <a href="/" role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                    </a>
                </div>

                <div id="navbarBasicExample" class="navbar-menu">
                    <div class="navbar-end">
                        <div class="navbar-item">
                            <div class="buttons">
                                <a href="/register" class="button background-color-primary has-text-white">
                                    Sign up
                                </a>
                                <a href="/login" class="button is-light">
                                    Sign in
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
    export default {
    	name: 'Header',
        props: ['user'],

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
