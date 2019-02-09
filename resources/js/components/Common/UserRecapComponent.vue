<template>
    <div class="column user__profile is-3 is-12-touch background-color-secondary">
        <div class="columns mg-t1">
            <div class="column user__profile__top">
                <div class="user__profile__top__img"
                     style="background: url('https://via.placeholder.com/150') no-repeat center center"></div>
            </div>
        </div>
        <div class="columns is-vcentered is-flex">
            <div class="user__right column">
                <div class="level is-mobile user__profile__username">
                    <a class="has-text-white full-w has-text-centered is-size-4"
                       :href="/user/ + user.username">
                        <strong>{{ user.name }}</strong>
                    </a>
                </div>
                <div class="level has-text-centered">
                    <p class="full-w has-text-center">@{{ user.username }}</p>
                </div>
            </div>
        </div>
        <hr>
        <div class="columns">
            <div class="column">
                <div class="level">
                    <a class="has-text-white" :href=" `/user/${user.username}` ">Tweets</a>
                    <span>{{ user.countPosts }}</span>
                </div>
                <div class="level">
                    <a class="has-text-white" :href=" `/user/${user.username}/followings` ">Followings</a>
                    <span>{{ user.countFollowings }}</span>
                </div>
                <div class="level">
                    <a class="has-text-white" :href=" `/user/${user.username}/followers` ">Followers</a>
                    <span>{{ user.countFollowers }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
	export default {
		name: "UserRecapComponent",
		props: ['user']
	}
</script>