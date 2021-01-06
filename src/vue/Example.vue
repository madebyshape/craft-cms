<template>
    <div>
        <a href="#" @click.prevent="getVisibility" v-show="visible">Click Me</a>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                visible: true
            }
        },
        methods: {
            getVisibility(event){
                console.log(this.visible);
                this.visible = false;
            }
        },
        computed: {
        },
        watch: {
            visible() {
                console.log('Visibility has changed!');
            }
        }
    }
</script>

<style lang="scss" scoped>
</style>