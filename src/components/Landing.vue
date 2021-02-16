<template>
    <div class="container">
        <h1 v-if="locale === 'fr'">En cours de construction...</h1>
        <h1 v-else>Under construction...</h1>
        <p v-if="locale === 'fr'">Je ne peux malheureusement pas vous donner la page que vous avez demandée... 😔</p>
        <p v-else>I'm so sorry to be unable to serve the page you were asking for... 😔</p>
        <img class="ui small rounded image centered" src="../assets/img/warning.svg">
        <p v-if="locale === 'fr'"><span class="ui yellow label">TIP</span> Je vous conseille de repasser plus tard, une fois que la page sera à nouveau accessible.</p>
        <p v-else><span class="ui yellow label">TIP</span> If I can advise you, you should come back later, when the page would be accessible again.</p>
    </div>
</template>

<script>
export default {
    name: "Landing",
    props: ['locale'],
    mounted: function () {
        this.displayTitle()
    },
    methods: {
        displayTitle: function () {
            if (this.locale === "fr") {
                document.title = `En cours de construction | ${this.$parent.$data.title}`
            } else {
                document.title = `Under construction | ${this.$parent.$data.title}`
            }
        }
    },
    watch: {
        locale: function () {
            this.displayTitle()
        }
    }
}
</script>

<style scoped>
img {
    margin-bottom: 10px;
}
</style>