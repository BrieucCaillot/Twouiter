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
                                <a class="has-text-black" :href=" `/user/${user.username}` ">Tweets</a>
                                <span>{{ user.countPosts }}</span>
                            </div>
                            <div class="level">
                                <a class="has-text-black" :href=" `/user/${user.username}/followings` ">Followings</a>
                                <span>{{ user.countFollowings }}</span>
                            </div>
                            <div class="level">
                                <a class="has-text-black" :href=" `/user/${user.username}/followers` ">Followers</a>
                                <span>{{ user.countFollowers }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-6 is-12-touch posts__center">
                    <NewTweetComponent></NewTweetComponent>
                    <PostComponent v-for="post in allPosts" :key="post.id" :post="post" :user="post.user"></PostComponent>
                </div>
            </div>
        </div>
    </main>
</template>

<script>

    import NewTweetComponent from './NewTweetComponent';
    import PostComponent from '../Common/PostComponent';

	export default {

		name: "Posts",
        components: {
	        NewTweetComponent,
		    PostComponent
        },
		data() {
			return {
				user: {
					posts: '',
					countPosts: ''
                },
				allPosts: ''
			}
		},
		methods: {
			getUser() {
				axios.get('/api/userc')
					.then((response) => this.user = response.data)
					.catch((error) => console.log(error))
			},
			getPosts() {
				axios.get('/api/allposts')
					.then((response) => {
						console.log(response)
						this.allPosts = response.data.data
                    })
					.catch((error) => console.log(error))
			}
		},
		beforeMount() {
			this.getUser()
			this.getPosts()
		}
	}
</script>

<style scoped>

</style>