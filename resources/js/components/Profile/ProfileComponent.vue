<template>
    <main id="content" class="user posts background-color-primary has-text-black">
        <div class="container is-fluid">
            <div class="columns is-multiline">
                <div class="column user__profile full-h is-3 is-12-touch has-background-white">
                    <div class="columns mg-t1">
                        <div class="column user__profile__top">
                            <div class="user__profile__top__img"
                                 style="background: url('https://via.placeholder.com/150') no-repeat center center"></div>
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
                                <button class="button is-success has-text-white mauto">Save</button>
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

                </div>
            </div>
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
				posts: '',
				followtext: '',
			}
		},
		computed: {
			isFollowable() {
				if (this.user.followers.length > 0) {
					for (let user in this.user.followers) {
						if (this.user.followers[user].id == this.userIdConnected) {
							this.followtext = "Unfollow"
                            return false;
                        }
						this.followtext = "Follow";
						return true;
					}
                }
				this.followtext = "Follow";
				return true;
			},
		},
		methods: {
			getUser(username) {
				axios.get(`/api/userc/${username}`)
					.then((response) => this.user = response.data)
					.catch((error) => {
						if (500 == error.response.status) window.location.href = '/'
					})
			},
			getPosts(username) {
				axios.get(`/api/user/posts/${username}`)
					.then((response) => this.posts = response.data)
					.catch((error) => {
						if (500 == error.response.status) window.location.href = '/'
					})
			},
			changeFollow(followtype) {
				axios.post(`/api/user/${followtype}`, {
					userId: this.user.id
				})
					.then((response) => this.getUser(this.username))
					.catch((error) => console.log(error))
			},
		},
		beforeMount() {
			let url = window.location.href.split('/');
			this.username = url.slice(url.length - 2, url.length - 1);
			this.getUser(this.username);
			this.getPosts(this.username);
		}
	}
</script>