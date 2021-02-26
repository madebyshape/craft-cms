<template>
    <div>
        {{ description }}
    </div>
</template>

<script>

    // import { defineAsyncComponent } from 'vue';
    // const AnotherComponent = defineAsyncComponent (() => import(/* webpackChunkName: "AnotherComponent" */'../vue/AnotherComponent.vue'));

    export default {
        // components: {
        //     AnotherComponent
        // },
        props: [],
        data() {
            return {
                description: 'Example Vue Component'
            }
        },
        methods: {},
        computed: {}
    }

</script>

<style lang="scss" scoped></style>