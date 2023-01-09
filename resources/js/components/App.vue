<template>
    <div>
        <div class="pt-5 container">
            <router-link to="/" class="me-2 text-decoration-none"
                >Home</router-link
            >
            <router-link to="/about" class="text-decoration-none"
                >About</router-link
            >
        </div>
        <router-view v-slot="{ Component, route }">
            <transition name="slide-fade" mode="out-in">
                <component :is="Component" ::key="route.path"></component>
            </transition>
        </router-view>
    </div>
</template>

<script>
export default {};
</script>
