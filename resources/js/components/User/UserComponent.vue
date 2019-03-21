<template>
    <main id="content" class="user posts has-text-black">
        <div v-if="user.username.length > 0" class="container is-fluid">
            <div class="columns is-multiline">
                <div class="column user__profile shadow full-h is-3 is-12-touch">
                    <div class="columns mg-t1">
                        <div class="column user__profile__top">
                            <div class="user__profile__top__img"
                                 :style="`background: url(${user.avatarUrl}) no-repeat center center / cover`"></div>
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
                                <a :href="`/user/${user.username}/profile`"
                                   class="button background-color-primary has-text-white mauto"
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
                            <a @click="changeView($event)" data-type="tweets"
                               class="user__profile__type has-text-centered is-block">Tweets</a>
                            <p class="user__profile__count has-text-centered">{{ user.countPosts }}</p>
                        </div>
                        <div class="column">
                            <a @click="changeView($event)" data-type="followings"
                               class="user__profile__type has-text-centered is-block">Followings</a>
                            <p class="user__profile__count has-text-centered">{{ user.countFollowings }}</p>
                        </div>
                        <div class="column">
                            <a @click="changeView($event)" data-type="followers"
                               class="user__profile__type has-text-centered is-block">Followers</a>
                            <p class="user__profile__count has-text-centered">{{ user.countFollowers }}</p>
                        </div>
                    </div>
                </div>
                <div class="column is-6 is-12-touch posts__center">
                    <div class="columns">
                        <div class="column pd0">
                            <div class="level">
                                <div class="level-left">
                                    <h1 v-if="selected == 'tweets'" class="color-secondary is-size-4">Latests tweets</h1>
                                    <h1 v-else-if="selected == 'followings'" class="color-secondary is-size-4">Followings</h1>
                                    <h1 v-else-if="selected == 'followers'" class="color-secondary is-size-4">Followers</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <PostComponent v-if="selected == 'tweets' && posts.data.length > 0" v-for="post in posts.data"
                                   :key="post.id"
                                   :post="post" :user="post.user" :userIdConnected="userIdConnected"></PostComponent>
                    <FollowComponent v-if="selected == 'followings' && user.paginateFollowings.data.length > 0"
                                     v-for="following in user.paginateFollowings.data" :key="following.id"
                                     :post="following"></FollowComponent>
                    <FollowComponent v-if="selected == 'followers' && user.paginateFollowers.data.length > 0"
                                     v-for="follower in user.paginateFollowers.data" :key="follower.id"
                                     :post="follower"></FollowComponent>
                    <div class="columns mg-t2">
                        <div class="column">
                            <div class="level">
                                <div class="level-item">
                                    <button v-if="posts.next_page_url !== null && selected == 'tweets'"
                                            @click="showMorePosts()"
                                            class="button background-color-primary has-text-white">Show more
                                    </button>
                                    <button v-else-if="user.paginateFollowings.next_page_url !== null && selected == 'followings'"
                                            @click="showMoreFollowings()"
                                            class="button background-color-primary has-text-white">Show more
                                    </button>
                                    <button v-else-if="user.paginateFollowers.next_page_url !== null && selected == 'followers'"
                                            @click="showMoreFollowers()"
                                            class="button background-color-primary has-text-white">Show more
                                    </button>
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
				user: {
					username: '',
					followers: '',
					followings: '',
					paginateFollowings: '',
					paginateFollowers: ''
				},
				posts: '',
				followtext: '',
				selected: 'tweets'
			}
		},
		computed: {
			isFollowable() {
				if (this.user.followers.length > 0) {
					for (let user in this.user.followers) {
						if (this.user.followers[user].id == this.userIdConnected) {
							this.followtext = "Unfollow";
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
			showMorePosts() {
				axios.get(this.posts.next_page_url)
					.then((response) => {
						this.posts.next_page_url = response.data.next_page_url
						for (let post in response.data.data) {
							this.posts.data.push(response.data.data[post]);
						}
					})
					.catch((error) => console.log(error))
			},
			showMoreFollowings() {
				axios.get(this.user.paginateFollowings.next_page_url)
					.then((response) => {
						this.user.paginateFollowings.next_page_url = response.data.paginateFollowings.next_page_url
						for (let following in response.data.paginateFollowings.data) {
							this.user.paginateFollowings.data.push(response.data.paginateFollowings.data[following]);
						}
					})
					.catch((error) => console.log(error))
			},
            showMoreFollowers() {
	            axios.get(this.user.paginateFollowers.next_page_url)
		            .then((response) => {
			            this.user.paginateFollowers.next_page_url = response.data.paginateFollowers.next_page_url
			            for (let following in response.data.paginateFollowers.data) {
				            this.user.paginateFollowers.data.push(response.data.paginateFollowers.data[following]);
			            }
		            })
		            .catch((error) => console.log(error))
			},
			changeFollow(followtype) {
				axios.post(`/api/user/${followtype}`, {
					userId: this.user.id
				})
					.then((response) => this.getUser(this.username))
					.catch((error) => console.log(error))
			},
			resetView(type) {
				this.selected = type;
			},
			changeView(event) {
				switch (event.target.getAttribute('data-type')) {
					case "tweets":
						location.hash = "tweets";
						this.resetView("tweets");
						break;
					case "followings":
						location.hash = "followings";
						this.resetView("followings");
						break;
					case "followers":
						location.hash = "followers"
						this.resetView("followers");
						break;
				}
			}
		},
		created() {
			let url = window.location.href.split('/');
			this.user.username = url.slice(url.length - 1);
            (location.hash) ? this.selected = location.hash.split('#').pop() : this.selected = "tweets"
			this.getUser(this.user.username);
			this.getPosts(this.user.username);
		}
	}
</script>