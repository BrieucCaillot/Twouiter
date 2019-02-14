<template>
    <main id="content" class="user posts background-color-primary has-text-black">
        <div class="container is-fluid">
            <form @submit.prevent="updateUser(user.username)" enctype="multipart/form-data" class="columns is-multiline">
                <div class="column user__profile full-h is-3 is-12-touch has-background-white">
                    <div class="columns mg-t1">
                        <div class="column user__profile__top">
                            <div class="user__profile__top__img"
                                 :style=" `background: url(${imageData}) no-repeat center center / cover`"></div>
                        </div>
                    </div>
                    <div class="columns is-vcentered is-flex">
                        <div class="user__right column">
                            <div class="level is-mobile user__profile__username">
                                <a class="has-text-black mauto has-text-centered is-size-4"
                                   :href="/user/ + user.username">
                                    <strong>{{ user.name }}</strong>
                                </a>
                            </div>
                            <div class="level has-text-centered">
                                <span class="mauto has-text-center">@{{ user.username }}</span>
                            </div>
                            <div class="level is-mobile">
                                <button type="submit" class="button is-success has-text-white mauto">Save</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="columns">
                        <div class="column">
                            <div class="level">
                                <a @click="changeView($event)" data-type="tweets" class="has-text-black">Tweets</a>
                                <span>{{ user.countPosts }}</span>
                            </div>
                            <div class="level">
                                <a @click="changeView($event)" data-type="followings"
                                   class="has-text-black">Followings</a>
                                <span>{{ user.countFollowings }}</span>
                            </div>
                            <div class="level">
                                <a @click="changeView($event)" data-type="followers"
                                   class="has-text-black">Followers</a>
                                <span>{{ user.countFollowers }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-6 is-12-touch posts__center">
                    <div class="columns">
                        <div class="column">
                            <div class="level">
                                <div class="level-left">
                                    <h1 class="color-secondary is-size-4 has-text-white">Profile</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="errors.message || errors.username || errors.name" class="notification is-danger">
                        <p v-if="errors.message > 0">- {{ errors.message }}</p>
                        <p v-if="errors.name.length > 0" v-for="error in errors.name">- {{ error }}</p>
                        <p v-if="errors.username.length > 0" v-for="error in errors.username">- {{ error }}</p>
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
                                    <img class="preview" :src="imageData">
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
				username: '',
				user: {
					followers: '',
					followings: ''
				},
                image: '',
				imageName: '',
				imageData: '',
				followtext: '',
				errors: {
					message: '',
					name: '',
					username: '',
				}
			}
		},
		methods: {
			getUser(username) {
				axios.get(`/api/userc/${username}`)
					.then((response) => this.user = response.data)
					.catch((error) => {
						if (500 == error.response.status) window.location.href = '/'
					})
			},
			previewImage(event) {
				let input = event.target;
				this.image = input.files[0];
				this.imageName = input.value.split("\\").pop();
				if (input.files && input.files[0]) {
					let reader = new FileReader();

					reader.onload = (e) => {
						this.imageData = e.target.result;
					}
					reader.readAsDataURL(input.files[0]);
				}
			},
			updateUser(username) {
				const formData = new FormData()
				formData.append('image', this.image, this.image.name)
				console.log(formData.get('image'));
				formData.append('name', this.user.name)
				formData.append('username', username)
				axios.post('/api/user/profile', formData, {headers: {'content-type': 'multipart/form-data'}})
					.then((reponse) => {
						console.log(reponse)
                        this.errors = '';
					})
					.catch((error) => {
						console.log(error.response.data);
						this.errors.message = error.response.data.message;
						this.errors.name = error.response.data.errors.name;
						this.errors.username = error.response.data.errors.username;
					})
			}
		},
		beforeMount() {
			let url = window.location.href.split('/');
			this.username = url.slice(url.length - 2, url.length - 1);
			this.getUser(this.username);
		}
	}
</script>