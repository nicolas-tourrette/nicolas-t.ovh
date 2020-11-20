<template>
	<div class="container">
		<h1 class="ui header blue">
			<i class="icon icofont-businessman"></i>
			<div class="content">
				Mon CV
				<div class="sub header">Consultez ici mon CV en ligne.</div>
			</div>
		</h1>
		<div class="ui top attached tabular menu">
			<router-link :to="{ 'name': 'cv-intro'}" class="item">Accueil</router-link>
			<router-link :to="{ 'name': 'cv-education'}" class="item">Formation</router-link>
			<router-link :to="{ 'name': 'cv-experience'}" class="item">Expériences</router-link>
			<router-link :to="{ 'name': 'cv-skills'}" class="item">Compétences</router-link>
			<router-link :to="{ 'name': 'cv-interests'}" class="item">Centres d'intérêt</router-link>
			<router-link :to="{ 'name': 'cv-projects'}" class="item">Projets et réalisations</router-link>
			<div class="ui menu right">
				<div class="ui simple dropdown item">
					Téléchargements <i class="dropdown icon"></i>
					<div class="menu">
						<a class="item" :href="'../assets/' + this.locale + '/cv/CV_Nicolas_TOURRETTE.pdf'" target="_blank">CV en PDF</a>
						<a class="item" :href="'../assets/' + this.locale + '/cv/CV_Nicolas_TOURRETTE_print.pdf'" target="_blank">CV à imprimer</a>
						<a class="item" :href="'../assets/fr/cv/Fiche_filiere.pdf'" target="_blank">Fiche filière en PDF</a>
						<a class="item" :href="'../assets/fr/cv/Fiche_filiere_NB.pdf'" target="_blank">Fiche filière à imprimer</a>
					</div>
				</div>
			</div>
		</div>
		<div class="ui bottom attached segment">
			<transition name="component-fade" mode="out-in">
				<router-view :locale="this.locale"></router-view>
			</transition>
		</div>
	</div>
</template>

<script>
export default {
	name: "CV",
	props: ["locale"],
	data: function () {
		return {
			title: `CV | ${this.$parent.$data.title}`,
		}
	},
	mounted: function () {
	},
	methods: {
		displayTitle: function () {
			if (this.locale === "fr") {
				this.title = `CV | ${this.$parent.$data.title}`
				
			} else {
				this.title = `My Resume | ${this.$parent.$data.title}`
			}
			document.title = this.title
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
.ui.menu.right {
	border: none;
	box-shadow: none;
}

.component-fade-enter-active, .component-fade-leave-active {
	transition: opacity .3s ease;
}

.component-fade-enter, .component-fade-leave-to {
	opacity: 0;
}
</style>