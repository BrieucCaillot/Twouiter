<template>
    <main id="content" class="user posts has-text-black">
        <div v-if="user.username.length > 0" class="container is-fluid">
            <form @submit.prevent="updateUser(user.username)" enctype="multipart/form-data"
                  class="columns is-multiline">
                <div class="column user__profile shadow full-h is-3 is-12-touch">
                    <div class="columns mg-t1">
                        <div class="column user__profile__top">
                            <div v-if="imageData" class="user__profile__top__img"
                                 :style=" `background: url(${imageData}) no-repeat center center / cover`"></div>
                            <div v-else-if="user.avatarUrl" class="user__profile__top__img"
                                 :style=" `background: url(${user.avatarUrl}) no-repeat center center / cover`"></div>
                        </div>
                    </div>
                    <div class="columns is-vcentered">
                        <div class="user__right column">
                            <div class="level is-mobile user__profile__name">
                                <a class="user__profile__name mauto has-text-centered"
                                   :href="/user/ + user.username">{{ user.name }}</a>
                            </div>
                            <div class="level has-text-centered">
                                <span class="mauto has-text-center user__profile__username">@{{ user.username }}</span>
                            </div>
                            <div class="level is-mobile">
                                <button type="submit" class="button is-success has-text-white mauto">Save</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="columns is-flex-mobile">
                        <div class="column">
                            <a :href="`/user/${user.username}/#tweets`" class="user__profile__type has-text-centered is-block">Tweets</a>
                            <p class="user__profile__count has-text-centered">{{ user.countPosts }}</p>
                        </div>
                        <div class="column">
                            <a :href="`/user/${user.username}/#followings`" class="user__profile__type has-text-centered is-block">Followings</a>
                            <p class="user__profile__count has-text-centered">{{ user.countFollowings }}</p>
                        </div>
                        <div class="column">
                            <a :href="`/user/${user.username}/#followers`" class="user__profile__type has-text-centered is-block">Followers</a>
                            <p class="user__profile__count has-text-centered">{{ user.countFollowers }}</p>
                        </div>
                    </div>
                </div>
                <div class="column posts__center pd4 shadow background-color-secondary is-6 is-12-touch">
                    <div class="columns">
                        <div class="column">
                            <div class="level">
                                <div class="level-left">
                                    <h1 class="has-text-white is-size-4">Profile</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="errors.name || errors.username || errors.email || errors.password"
                         class="notification is-danger">
                        <p v-if="errors.name.length > 0" v-for="error in errors.name">- {{ error }}</p>
                        <p v-if="errors.username.length > 0" v-for="error in errors.username">- {{ error }}</p>
                        <p v-if="errors.email.length > 0" v-for="error in errors.email">- {{ error }}</p>
                        <p v-if="errors.password.length > 0" v-for="error in errors.password">- {{ error }}</p>
                    </div>
                    <div v-if="success.length > 0" class="notification is-success">
                        {{ success }}
                    </div>
                    <div class="columns">
                        <div class="column">
                            <div class="level">
                                <div class="field full-w">
                                    <label class="label has-text-white">Name</label>
                                    <div class="control">
                                        <input class="input" type="text" placeholder="Name" v-model="user.name">
                                    </div>
                                </div>
                            </div>
                            <div class="level">
                                <div class="field full-w">
                                    <label class="label has-text-white">Username</label>
                                    <div class="control">
                                        <input class="input" type="text" placeholder="Username" v-model="user.username">
                                    </div>
                                </div>
                            </div>
                            <div class="level">
                                <div class="field full-w">
                                    <label class="label has-text-white">Email</label>
                                    <div class="control">
                                        <input class="input" type="email" placeholder="Email" v-model="user.email">
                                    </div>
                                </div>
                            </div>
                            <div class="level">
                                <div class="field full-w">
                                    <label class="label has-text-white">Current password</label>
                                    <div class="control">
                                        <input class="input" type="password" placeholder="Current password"
                                               v-model="user.oldpassword">
                                    </div>
                                </div>
                            </div>
                            <div class="level">
                                <div class="field full-w">
                                    <label class="label has-text-white">New password</label>
                                    <div class="control">
                                        <input class="input" type="password" placeholder="Repeat new password"
                                               v-model="password">
                                    </div>
                                </div>
                            </div>
                            <div class="level">
                                <div class="field full-w">
                                    <label class="label has-text-white">New password</label>
                                    <div class="control">
                                        <input class="input" type="password" placeholder="Repeat new password"
                                               v-model="password_confirmation">
                                    </div>
                                </div>
                            </div>
                            <div class="level">
                                <div class="field">
                                    <label class="label has-text-white">Profile picture</label>
                                    <div class="file" :class="{ 'has-name': imageData.length > 0 }">
                                        <label class="file-label">
                                            <input type="file" class="file-input" @change="previewImage($event)"
                                                   accept="image/*">
                                            <span class="file-cta">
                                            <span class="file-icon">
                                            📌
                                            </span>
                                            <span class="file-label">
                                                Choose a file…
                                            </span>
                                        </span>
                                            <span v-if="imageData.length > 0" class="file-name has-text-white">{{ imageName }}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="level" v-if="imageData.length > 0">
                                <div class="image-preview">
                                    <img class="preview" :src="imageData" alt="image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
</template>

<script>

	import PostComponent from '../Common/PostComponent';
	import FollowComponent from '../Common/FollowComponent';

	export default {
		name: "UserComponent",
		props: ['userIdConnected'],
		components: {
			PostComponent,
			FollowComponent
		},
		data() {
			return {
				user: {
    				username: '',
					followers: '',
					followings: '',
				},
				oldpassword: '',
				password: '',
				password_confirmation: '',
				image: '',
				imageName: '',
				imageData: '',
				followtext: '',
				success: '',
				errors: {
					name: '',
					username: '',
				}
			}
		},
		methods: {
			getUser(username) {
				axios.get(`/api/userc/${username}`)
					.then((response) => this.user = response.data)
					.catch((error) => console.log(error))
			},
			previewImage(event) {
				let input = event.target;
				this.image = input.files[0];
				this.imageName = input.value.split("\\").pop();
				if (input.files && input.files[0]) {
					let reader = new FileReader();

					reader.onload = (e) => {
						this.imageData = e.target.result;
					};
					reader.readAsDataURL(input.files[0]);
				}
			},
			updateUser(username) {
				this.success = '';
				const formData = new FormData();
				formData.append('name', this.user.name);
				formData.append('username', username);
				formData.append('email', this.user.email);
				formData.append('oldpassword', this.user.oldpassword);
				formData.append('password', this.password);
				formData.append('password_confirmation', this.password_confirmation);
				formData.append('image', this.image, this.image.name);
				axios.post('/api/user/profile', formData, {headers: {'content-type': 'multipart/form-data'}})
					.then((reponse) => {
						this.errors = {};
						this.success = reponse.data
					})
					.catch((error) => {
						this.errors = {};
						this.errors = error.response.data.errors;
					})
			}
		},
		created() {
			let url = window.location.href.split('/');
			this.user.username = url.slice(url.length - 2, url.length - 1);
			this.getUser(this.user.username);
		}
	}
</script>