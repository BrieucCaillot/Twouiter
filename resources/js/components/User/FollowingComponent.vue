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
                                    <h1 class="color-secondary is-size-4 has-text-white">Followings</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <FollowComponent v-if="user.followings.length > 0" v-for="following in user.followings" :key="following.id" :post="following"></FollowComponent>
                    <div v-else>
                        No Followings
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>

	import UserRecapComponent from '../Common/UserRecapComponent';
	import FollowComponent from '../Common/FollowComponent';

	export default {
		name: "FollowingComponent",
		components: {
			UserRecapComponent,
			FollowComponent
		},
		data() {
			return {
				user: {
				    followings: ''
                },
            }
		},
		methods: {
			getUser(username) {
				axios.get(`/api/userc/${username}`)
					.then((response) => this.user = response.data)
					.catch((error) =>  {
						if (500 == error.response.status) window.location.href = '/'
                    })
			}
		},
		beforeMount() {
			let url = window.location.href.split('/');
			let username = url.slice(4, 5);
			this.getUser(username);
		}
	}
</script>