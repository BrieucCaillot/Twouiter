<template>
    <main class="login background-color-secondary">
        <section>
            <div class="login__content columns">
                <div class="login__content__left column is-6"></div>
                <div class="column is-6 background-color-primary">
                    <div class="login__content__right">
                        <form @submit.prevent="loginForm()">
                            <div class="level">
                                <h1 class="is-size-3 has-text-white">Sign In</h1>
                            </div>
                            <div class="level">
                                <div class="field full-w">
                                    <label for="username" class="label has-text-white">Username</label>
                                    <div class="control">
                                        <input id="username" v-model="username" name="username" class="input" type="text"
                                               placeholder="Username">
                                    </div>
                                    <!--<p class="help is-success">This username is available</p>-->
                                </div>
                            </div>
                            <div class="level">
                                <div class="field full-w">
                                    <label for="password" class="label has-text-white">Password</label>
                                    <div class="control">
                                        <input id="password" v-model="password" class="input" type="password" placeholder="Password">
                                    </div>
                                    <!--<p class="help is-danger">This email is invalid</p>-->
                                </div>
                            </div>
                            <div class="level">
                                <button class="button background-color-secondary has-text-white" type="submit">Connect</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script>
	export default {
		name: 'Login',
        data() {
		    return {
		        username: '',
                password: ''
            }
        },
        methods: {
	        loginForm() {
                axios.post('/login', this.data)
                    .then((response) => {
                    	console.log(response)
                    })
                    .catch((error) => {
	                    console.log(error)
                    })
            }
        }
	}
</script>
