<template>
    <main id="content" class="login background-color-white">
        <div class="login__content columns full-h">
            <div class="login__content__left column is-6"></div>
            <div class="column is-6 background-color-primary">
                <div class="login__content__right">
                    <form @submit.prevent="loginForm()">
                        <div class="level">
                            <h1 class="is-size-3 has-text-white">Sign Up</h1>
                        </div>
                        <div v-if="errors.username || errors.email || errors.password" class="notification is-danger">
                            <p v-if="errors.username.length > 0" v-for="error in errors.username">- {{ error }}</p>
                            <p v-if="errors.email.length > 0" v-for="error in errors.email">- {{ error }}</p>
                            <p v-if="errors.password.length > 0" v-for="error in errors.password">- {{ error }}</p>
                        </div>
                        <div class="level">
                            <div class="field full-w">
                                <label for="name" class="label has-text-white">Name</label>
                                <div class="control">
                                    <input id="name" v-model="name" name="name" class="input"
                                           type="text"
                                           placeholder="Name">
                                </div>
                            </div>
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
                                <label for="email" class="label has-text-white">Email</label>
                                <div class="control">
                                    <input id="email" v-model="email" class="input" type="email"
                                           placeholder="Password">
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
                            <div class="field full-w">
                                <label for="password_confirmation" class="label has-text-white">Password</label>
                                <div class="control">
                                    <input id="password_confirmation" v-model="password_confirmation" class="input" type="password"
                                           placeholder="Confirm password">
                                </div>
                            </div>
                        </div>
                        <div class="level">
                            <button class="button background-color-white has-text-black" type="submit">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
	export default {
		name: 'Register',
		data() {
			return {
				name: '',
				username: '',
				email: '',
				password: '',
				password_confirmation: '',
				errors: {
					username: '',
                    email: '',
                    password: '',
				}
			}
		},
		methods: {
			loginForm() {
				axios.post('/register', {
					name: this.name,
					username: this.username,
					email: this.email,
					password: this.password,
					password_confirmation: this.password_confirmation,
				})
					.then((response) => (response.status == 200) ? location.reload() : null)
					.catch((error) => {
						console.log(error);
						this.errors.username = error.response.data.errors.username
						this.errors.email = error.response.data.errors.email
						this.errors.password = error.response.data.errors.password
					})
			}
		}
	}
</script>
