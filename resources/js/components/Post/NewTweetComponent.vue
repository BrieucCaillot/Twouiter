<template>
    <div class="posts__newpost columns background-color-secondary has-text-white">
        <div class="column">
            <form @submit.prevent="newTweet()" method="POST">
                <div class="level">
                    <h1 class="is-size-4">Quoi de neuf ?</h1>
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
</template>

<script>
	export default {
		name: "NewTweetComponent",
        data() {
		    return {
			    message: '',
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
						        this.getPosts();
						        this.user.countPosts++
					        };
				        })
				        .catch((error) => {
					        console.log(error);
				        })
		        }
	        }
        }
	}
</script>