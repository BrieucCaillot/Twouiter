<template>
    <main id="content" class="posts">
        <div class="container is-fluid">
            <div v-if="user" class="columns is-multiline">
                <div class="column user__profile shadow full-h is-3 is-12-touch">
                    <div v-if="user.image" class="columns mg-t1">
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
                        </div>
                    </div>
                    <hr>
                    <div class="columns is-flex-mobile">
                        <div class="column">
                            <p class="user__profile__type has-text-centered">Tweets</p>
                            <p class="user__profile__count has-text-centered">{{ user.countPosts }}</p>
                        </div>
                        <div class="column">
                            <p class="user__profile__type has-text-centered">Followings</p>
                            <p class="user__profile__count has-text-centered">{{ user.countFollowings }}</p>
                        </div>
                        <div class="column">
                            <p class="user__profile__type has-text-centered">Followers</p>
                            <p class="user__profile__count has-text-centered">{{ user.countFollowers }}</p>
                        </div>
                    </div>
                </div>
                <div class="column is-6 is-12-touch posts__center">
                    <div class="posts__newpost shadow columns background-color-secondary has-text-white">
                        <div class="column">
                            <form @submit.prevent="newTweet()" method="POST">
                                <div class="level">
                                    <h1 class="is-size-4">Whats up ?</h1>
                                </div>
                                <div class="level">
                                    <textarea required class="textarea" rows="2" type="text" v-model="message"
                                              placeholder="Your message"></textarea>
                                </div>
                                <div class="level">
                                    <div class="level-left">
                                        {{ message.length }} / 250
                                    </div>
                                    <div class="level-right">
                                        <button v-if="message.length < 250" class="button background-color-primary has-text-white" type="submit">
                                            Send
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <PostComponent v-if="allPosts.data.length > 0" v-for="post in allPosts.data" :key="post.id" :post="post" :user="post.user"
                                   :userIdConnected="user.id"></PostComponent>
                    <div v-if="allPosts.data.length > 0 && allPosts.next_page_url !== null" class="columns mg-t2">
                        <div class="column">
                            <div class="level">
                                <div class="level-item">
                                    <button @click="showMorePosts()" class="button background-color-primary has-text-white">Show more</button>
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

	export default {
		name: "Posts",
		components: {
			PostComponent
		},
		data() {
			return {
				message: '',
				user: '',
				allPosts: {
					data: {}
                }
			}
		},
		methods: {
			newTweet() {
				if (this.message.length > 0) {
					axios.post('/post', {
						message: this.message
					})
						.then((response) => {
							if (response.status == 200) {
								this.message = '';
								this.getUser();
								this.getPosts();
							}
						})
						.catch((error) => {
							console.log(error);
						})
				}
			},
			getUser() {
				axios.get('/api/userc')
					.then((response) => this.user = response.data)
					.catch((error) => console.log(error))
			},
			getPosts() {
				axios.get('/api/allposts')
					.then((response) => this.allPosts = response.data)
					.catch((error) => console.log(error))
			},
            showMorePosts() {
	            axios.get(this.allPosts.next_page_url)
		            .then((response) => {
			            this.allPosts.next_page_url = response.data.next_page_url
			            for (let post in response.data.data) {
			                this.allPosts.data.push(response.data.data[post]);
                        }
		            })
		            .catch((error) => console.log(error))
            }
		},
		beforeMount() {
			this.getUser();
			this.getPosts();
			setInterval(() => {
				this.getPosts()
			}, 60000)
		}
	}
</script>

<style scoped>

</style>