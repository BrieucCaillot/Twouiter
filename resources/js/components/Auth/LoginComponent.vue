<template>
    <main id="content" class="login has-background-white">
        <div class="login__content columns full-h">
            <div class="login__content__left column is-6"></div>
            <div class="column is-6 background-color-primary">
                <div class="login__content__right">
                    <form @submit.prevent="loginForm()">
                        <div class="level">
                            <h1 class="is-size-3 has-text-white">Sign In</h1>
                        </div>
                        <div v-if="errors.username || errors.password" class="notification is-danger">
                            <p v-for="error in errors.username">- {{ error }}</p>
                            <p v-for="error in errors.password">- {{ error }}</p>
                        </div>
                        <div class="level">
                            <div class="field full-w">
                                <label for="username" class="label has-text-white">Username</label>
                                <div class="control">
                                    <input id="username" v-model="username" name="username" class="input"
                                           type="text"
                                           placeholder="Username">
                                </div>
                            </div>
                        </div>
                        <div class="level">
                            <div class="field full-w">
                                <label for="password" class="label has-text-white">Password</label>
                                <div class="control">
                                    <input id="password" v-model="password" class="input" type="password"
                                           placeholder="Password">
                                </div>
                            </div>
                        </div>
                        <div class="level">
                            <button class="button background-color-secondary has-text-white" type="submit">Connect</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
	export default {
		name: 'Login',
		data() {
			return {
				username: '',
				password: '',
				errors: {
					username: '',
					password: '',
				}
			}
		},
		methods: {
			loginForm() {
				axios.post('/login', {
					username: this.username,
					password: this.password,
				})
					.then((response) => (response.status == 200) ? location.reload() : null)
					.catch((error) => {
						this.errors.username = error.response.data.errors.username
						this.errors.password = error.response.data.errors.password
					})
			}
		},
		mounted() {
			console.log(this.errors.username.length)
		}
	}
</script>
