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
					{{ locale === 'fr' ? "Voir mon CV" : "Go to my Resume" }} <i class="icon right icofont-businessman"></i>
				</router-link>
			</div>
		</div>
		<h2>{{ $t('Home.Page.Welcome.Title') }}</h2>
		<i18n path="Home.Page.Welcome.Content1" tag="p">
			<template v-slot:contentUpdate>{{ $root.$children[0].$data.lastContentUpdate | date(locale) }}</template>
			<template v-slot:softUpdate>{{ $root.$children[0].$data.lastUpdated | date(locale) }}</template>
			<template v-slot:vue-link><a href="https://fr.vuejs.org">VueJS</a></template>
			<template v-slot:semantic-link><a href="https://semantic-ui.com">Semantic UI</a></template>
		</i18n>
		<i18n path="Home.Page.Welcome.Content2" tag="p">
			<template v-slot:actualite>
				<router-link :to="{name: 'news'}">{{ locale === 'fr' ? "actualité" : "news" }}</router-link>
			</template>
			<template v-slot:cv>
				<strong>
					<router-link :to="{name: 'cv'}">{{ locale === 'fr' ? "CV" : "Resume" }}</router-link>
				</strong>
			</template>
		</i18n>
		<h2>{{ $t('Home.Page.OtherSpaces.Title') }}</h2>
		<div class="ui three column grid stackable">
			<div class="column">
				<div class="ui fluid special card">
					<div class="blurring dimmable image">
						<div class="ui inverted dimmer">
							<div class="content">
								<div class="center">
									<a class="ui primary button" href="https://www.apgmb.fr" target="_blank">
										{{ $t('Home.Page.OtherSpaces.Content.APGMB.Website.Link') }}
									</a>
								</div>
							</div>
						</div>
						<img src="https://www.apgmb.fr/wp-content/uploads/2019/07/logo-1.jpg">
					</div>
					<div class="content">
						<a class="header">{{ $t('Home.Page.OtherSpaces.Content.APGMB.Website.Title') }}</a>
						<div class="meta">
							<span class="date">{{ $t('Home.Page.OtherSpaces.Content.APGMB.Website.Date') }}</span>
						</div>
					</div>
					<div class="content">
						{{ $t('Home.Page.OtherSpaces.Content.APGMB.Website.Text') }}
					</div>
				</div>
			</div>
			<div class="column">
				<div class="ui fluid special card">
					<div class="blurring dimmable image">
						<div class="ui inverted dimmer">
							<div class="content">
								<div class="center">
									<a class="ui primary button" href="https://gem.apgmb.fr" target="_blank">
										{{ $t('Home.Page.OtherSpaces.Content.APGMB.GEM.Link') }}
									</a>
								</div>
							</div>
						</div>
						<img src="https://image.flaticon.com/icons/svg/1407/1407631.svg">
					</div>
					<div class="content">
						<a class="header">{{ $t('Home.Page.OtherSpaces.Content.APGMB.GEM.Title') }}</a>
						<div class="meta">
							<span class="date">{{ $t('Home.Page.OtherSpaces.Content.APGMB.GEM.Date') }}</span>
						</div>
					</div>
					<div class="content" v-html="$t('Home.Page.OtherSpaces.Content.APGMB.GEM.Text')"></div>
				</div>
			</div>
			<div class="column">
				<div class="ui fluid special card">
					<div class="blurring dimmable image">
						<div class="ui inverted dimmer">
							<div class="content">
								<div class="center">
									<a class="ui primary button" href="https://esirem.nicolas-t.ovh" target="_blank">
										{{ $t('Home.Page.OtherSpaces.Content.ESIREM.Link') }}
									</a>
								</div>
							</div>
						</div>
						<img src="https://esirem.u-bourgogne.fr/wp-content/uploads/2019/12/cropped-logo-couleur-site-web.png">
					</div>
					<div class="content">
						<a class="header">{{ $t('Home.Page.OtherSpaces.Content.ESIREM.Title') }}</a>
						<div class="meta">
							<span class="date">{{ $t('Home.Page.OtherSpaces.Content.ESIREM.Date') }}</span>
						</div>
					</div>
					<div class="content">
						{{ $t('Home.Page.OtherSpaces.Content.ESIREM.Text') }}
					</div>
				</div>
			</div>
			<div class="column">
				<div class="ui fluid special card">
					<div class="blurring dimmable image">
						<div class="ui inverted dimmer">
							<div class="content">
								<div class="center">
									<a class="ui primary button" href="https://gigapysoftware.wordpress.com/solutions/geobrevet" target="_blank">
										{{ $t('Home.Page.OtherSpaces.Content.LearnApp.Link') }}
									</a>
								</div>
							</div>
						</div>
						<img src="https://gigapysoftware.files.wordpress.com/2016/02/80771f_e44bf8d0bc9c4389a5cf680d2199e754.png?w=700">
					</div>
					<div class="content">
						<a class="header">{{ $t('Home.Page.OtherSpaces.Content.LearnApp.Title') }}</a>
						<div class="meta">
							<span class="date">{{ $t('Home.Page.OtherSpaces.Content.LearnApp.Date') }}</span>
							<div class="ui teal progress" data-percent="40" id="progressLearnApp">
								<div class="bar"></div>
								<div class="label">40 %</div>
							</div>
						</div>
					</div>
					<div class="content">
						{{ $t('Home.Page.OtherSpaces.Content.LearnApp.Text') }}
					</div>
				</div>
			</div>
			<div class="column">
				<div class="ui fluid special card">
					<div class="blurring dimmable image">
						<div class="ui inverted dimmer">
							<div class="content">
								<div class="center">
									<a class="ui primary button" href="https://www.nicolas-t.ovh/livres" target="_blank">
										{{ $t('Home.Page.OtherSpaces.Content.Books.Link') }}
									</a>
								</div>
							</div>
						</div>
						<img src="https://www.nicolas-t.ovh/livres/wp-content/uploads/2020/03/favicon.png">
					</div>
					<div class="content">
						<a class="header">{{ $t('Home.Page.OtherSpaces.Content.Books.Title') }}</a>
						<div class="meta">
							<span class="date">{{ $t('Home.Page.OtherSpaces.Content.Books.Date') }}</span>
						</div>
					</div>
					<div class="content">
						{{ $t('Home.Page.OtherSpaces.Content.Books.Text') }}
					</div>
				</div>
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
		$('.special.card .image').dimmer({
			on: 'hover'
		})
		$('#progressLearnApp').progress();
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
				return moment(date).format('DD/MM/YYYY')
			} else {
				return moment(date).format('M.DD.YYYY')
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

.dimmer .content {
	margin-left: 0;
}

#progressLearnApp {
	margin-top: 10px;
}

a.button {
	transition: transform .3s !important;
}

a.button:hover {
	transform: scale(.95);
}

a.header {
	cursor: text !important;;
}
</style>
