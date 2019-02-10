<template>
    <main id="content" class="posts background-color-primary">
        <div class="container is-fluid">
            <div class="columns is-multiline">
                <div class="column is-3 is-12-touch">
                    <div class="columns is-vcentered posts__user is-flex has-background-white">
                        <div class="posts__user__left column ">
                            <div class="posts__user__left__img"
                                 style="background: url('https://via.placeholder.com/150') no-repeat center center"></div>
                        </div>
                        <div class="posts__user__right column has-text-black">
                            <div class="level posts__user__right__top">
                                <a :href="/user/ + user.username"><strong class="is-size-5 has-text-black">{{ user.name }}</strong></a>
                            </div>
                            <div class="level">
                                <p>@{{ user.username }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="columns posts__user has-background-white has-text-black mg-t2">
                        <div class="column">
                            <div class="level">
                                <span class="has-text-black">Tweets</span>
                                <span>{{ user.countPosts }}</span>
                            </div>
                            <div class="level">
                                <span class="has-text-black">Followings</span>
                                <span>{{ user.countFollowings }}</span>
                            </div>
                            <div class="level">
                                <span class="has-text-black">Followers</span>
                                <span>{{ user.countFollowers }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-6 is-12-touch posts__center">
                    <div class="posts__newpost columns has-background-white has-text-white">
                        <div class="column">
                            <form @submit.prevent="newTweet()" method="POST">
                                <div class="level">
                                    <h1 class="is-size-4 has-text-black">Quoi de neuf ?</h1>
                                </div>
                                <div class="level">
                                    <textarea class="textarea" rows="2" type="text" v-model="message" placeholder="Whats up ?"></textarea>
                                </div>
                                <div class="level">
                                    <button class="button background-color-primary has-text-white" type="submit">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <PostComponent v-for="post in allPosts" :key="post.id" :post="post" :user="post.user" :userIdConnected="user.id"></PostComponent>
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
				allPosts: ''
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
								this.getUser();
								this.getPosts();
							};
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
					.then((response) => {
						console.log(response)
						this.allPosts = response.data
                    })
					.catch((error) => console.log(error))
			}
		},
		beforeMount() {
			this.getUser()
			this.getPosts()
            setInterval(() => {
	            this.getPosts()
            }, 60000)
		}
	}
</script>

<style scoped>

</style>