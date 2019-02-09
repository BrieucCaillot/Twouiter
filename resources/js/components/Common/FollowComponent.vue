<template>
    <div class="columns">
        <div class="column">
            <div class="columns">
                <div class="column">
                    <div class="posts__post mg-t1 has-background-white columns is-vcentered is-flex">
                        <div class="column posts__post__left">
                            <a :href="/user/ + post.username">
                                <div class="posts__post__left__img"
                                     style="background: url('https://via.placeholder.com/150') no-repeat center center"></div>
                            </a>
                        </div>
                        <div class="column posts__post__right">
                            <div class="level is-mobile has-text-left">
                                <div class="level-left">
                                    <a :href="/user/ + post.username">
                                        <strong class="posts__post__right__name">{{ post.name }}</strong>
                                    </a>
                                    <span class="posts__post__right__username">@{{ post.username }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
	export default {
		name: "PostComponent",
        props: ['post'],
	}
</script>