<template>
    <main id="content" class="user posts has-text-black">
        <div class="container is-fluid">
            <div class="columns is-multiline">
                <div class="column user__profile shadow full-h is-3 is-12-touch">
                    <div class="columns mg-t1">
                        <div class="column user__profile__top">
                            <div class="user__profile__top__img"
                                 :style="`background: url(/storage/avatars/${user.image}) no-repeat center center / cover`"></div>
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
                                <a :href="`/user/${username}/profile`" class="button background-color-primary has-text-white mauto"
                                        v-if="userIdConnected == user.id">Edit Profile
                                </a>
                                <button @click="changeFollow('follow')" class="button is-success has-text-white mauto"
                                        v-else-if="isFollowable">{{ followtext }}
                                </button>
                                <button @click="changeFollow('unfollow')" class="button is-danger has-text-white mauto"
                                        v-else-if="!isFollowable">{{ followtext }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="columns is-flex-mobile">
                        <div class="column">
                            <p @click="changeView($event)" data-type="tweets" class="user__profile__type has-text-centered c-pointer">Tweets</p>
                            <p class="user__profile__count has-text-centered">{{ user.countPosts }}</p>
                        </div>
                        <div class="column">
                            <p @click="changeView($event)" data-type="followings" class="user__profile__type has-text-centered c-pointer">Followings</p>
                            <p class="user__profile__count has-text-centered">{{ user.countFollowings }}</p>
                        </div>
                        <div class="column">
                            <p @click="changeView($event)" data-type="followers" class="user__profile__type has-text-centered c-pointer">Followers</p>
                            <p class="user__profile__count has-text-centered">{{ user.countFollowers }}</p>
                        </div>
                    </div>
                </div>
                <div class="column is-6 is-12-touch posts__center">
                    <div class="columns">
                        <div class="column pd0">
                            <div class="level">
                                <div class="level-left">
                                    <h1 class="color-secondary is-size-4">{{ title }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <PostComponent v-if="selected.tweets && posts.length > 0" v-for="post in posts" :key="post.id"
                                   :post="post" :user="post.user" :userIdConnected="userIdConnected"></PostComponent>
                    <FollowComponent v-if="selected.followings && user.followings.length > 0"
                                     v-for="following in user.followings" :key="following.id"
                                     :post="following"></FollowComponent>
                    <FollowComponent v-if="selected.followers && user.followers.length > 0"
                                     v-for="follower in user.followers" :key="follower.id"
                                     :post="follower"></FollowComponent>
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
				title: 'Latest tweets',
				followtext: '',
				selected: {
					tweets: true,
					followings: false,
					followers: false,
				}
			}
		},
		computed: {
			isFollowable() {
				if (this.user.followers.length > 0) {
					for (let user in this.user.followers) {
						if (this.user.followers[user].id == this.userIdConnected) {
							this.followtext = "Unfollow";
							console.log('if', this.followtext);
							return false;
						}
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
			resetView(type) {
				for (let view in this.selected) {
					this.selected[view] = false;
					this.selected[type] = true
				}
			},
			changeView(event) {
				switch (event.target.getAttribute('data-type')) {
					case "tweets":
						this.title = "Latest tweets";
						this.resetView("tweets");
						break;
					case "followings":
						this.title = "Followings";
						this.resetView("followings");
						break;
					case "followers":
						this.title = "Followers";
						this.resetView("followers");
						break;
				}
			}
		},
		beforeMount() {
			let url = window.location.href.split('/');
			this.username = url.slice(url.length - 1);
			this.getUser(this.username);
			this.getPosts(this.username);
		}
	}
</script>