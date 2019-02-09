<template>
    <main id="content" class="user posts background-color-primary has-text-white">
        <div class="container is-fluid">
            <div class="columns is-multiline">
                <UserRecapComponent :user="user"></UserRecapComponent>
                <div class="column is-6 is-12-touch posts__center">
                    <div class="columns">
                        <div class="column">
                            <div class="level">
                                <div class="level-left">
                                    <h1 class="color-secondary is-size-4 has-text-white">Latests tweets</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <PostComponent v-if="posts.length > 0" v-for="post in posts" :key="post.id" :post="post" :user="user"></PostComponent>
                </div>
            </div>
        </div>
    </main>
</template>

<script>

    import UserRecapComponent from '../Common/UserRecapComponent';
    import PostComponent from '../Common/PostComponent';

	export default {
		name: "UserComponent",
        components: {
	        UserRecapComponent,
		    PostComponent
        },
		data() {
			return {
				user: '',
                posts: ''
            }
		},
		methods: {
			getUser(username) {
				axios.get(`/api/userc/${username}`)
					.then((response) => this.user = response.data)
					.catch((error) =>  {
						if (500 == error.response.status) window.location.href = '/'
					})
			},
            getPosts(username) {
	            axios.get(`/api/user/posts/${username}`)
		            .then((response) => {console.log(response); this.posts = response.data})
		            .catch((error) =>  {
			            if (500 == error.response.status) window.location.href = '/'
		            })
            }
		},
		beforeMount() {
			let url = window.location.href.split('/');
			let username = url.slice(url.length-1);
			this.getUser(username);
			this.getPosts(username);
		}
	}
</script>