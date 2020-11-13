<template>
	<div class="container">
		<div class="ui segment piled blue inverted">
			<h1 class="ui header">Nicolas TOURRETTE</h1>
			<h3 class="ui header">{{ this.$parent.$children[1].$data.description }}</h3>
		</div>
		<div class="ui grid">
			<div class="twelve wide column">
				<router-link class="ui huge primary button" :to="{name: 'news'}">
					{{ locale === 'fr' ? "Voir mes actualités" : "Read my news" }} <i class="right newspaper outline icon"></i>
				</router-link>
				<router-link class="ui huge teal button" :to="{name: 'publications'}">
					{{ locale === 'fr' ? "Voir mes publications" : "Read my publications" }} <i class="right newspaper outline icon"></i>
				</router-link>
			</div>
			<div class="four wide column right aligned">
				<router-link class="ui huge red button" :to="{name: 'cv'}">
					{{ locale === 'fr' ? "Voir mon CV" : "Go to my Resume" }} <i class="right id card outline outline icon"></i>
				</router-link>
			</div>
		</div>
		<div class="ui grid">
			<div class="column">
				<i18n path="Home.Home_Welcome1" tag="p">
					<template v-slot:date>
						{{ $root.$children[0].$data.lastUpdated | date(locale) }}
					</template>
					<template v-slot:vue-link>
						<a href="https://fr.vuejs.org">VueJS</a>
					</template>
					<template v-slot:semantic-link>
						<a href="https://semantic-ui.com">Semantic UI</a>
					</template>
				</i18n>
				<i18n path="Home.Home_Welcome2" tag="p">
					<template v-slot:actualite>
						<router-link :to="{name: 'news'}">{{ locale === 'fr' ? "actualité" : "news" }}</router-link>
					</template>
					<template v-slot:cv>
						<strong>
							<router-link :to="{name: 'cv'}">{{ locale === 'fr' ? "CV" : "Resume" }}</router-link>
						</strong>
					</template>
				</i18n>
			</div>
		</div>
	</div>
</template>

<script>
import moment from 'moment'

export default {
	name: 'Home',
	props: ['locale'],
	mounted: function () {
		this.displayTitle()
	},
	methods: {
		displayTitle: function () {
			if (this.locale === "fr") {
				document.title = `Accueil | ${this.$parent.$data.title}`
			} else {
				document.title = `Home | ${this.$parent.$data.title}`
			}
		}
	},
	filters: {
		date: function (date, locale) {
			if (locale === "fr") {
				return moment(date).format('DD/MM/YYYY');
			} else {
				return moment(date).format('M.DD.YYYY');
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

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.container h1, h2, h3 {
	text-align: center;
}

.container h1 {
	font-size: 3rem;
}

.container h3 {
	margin-top: -7px;
}

a.button {
	transition: transform .3s !important;
}

a.button:hover {
	transform: scale(.95);
}
</style>
