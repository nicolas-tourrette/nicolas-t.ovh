<template>
	<div class="ui left fixed vertical menu inverted dark-grey">
		<div class="item photo">
			<img class="photo" alt="Nicolas TOURRETTE" src="../assets/img/personal.jpg">
		</div>
		<h1>Nicolas TOURRETTE</h1>
		<div class="item description-item">
			<p class="description" v-html="this.description"></p>
		</div>
		<div class="scroll-menu">
			<div class="scroll">
				<router-link :to="{ name: 'home'}" class="item">{{ $t("Sidebar.Accueil") }}</router-link>
				<router-link :to="{ name: 'news'}" class="item">{{ $t("Sidebar.Actualites") }}</router-link>
				<router-link :to="{ name: 'publications'}" class="item">{{ $t("Sidebar.Publications") }}</router-link>
				<router-link :to="{ name: 'mariage'}" class="item">{{ $t("Sidebar.Mariage") }}</router-link>
				<router-link :to="{ name: 'cv'}" class="item">{{ $t("Sidebar.CV") }}</router-link>
				<router-link :to="{ name: 'infos'}" class="item">{{ $t("Sidebar.Informations") }}</router-link>
				<a class="item" href="mailto:contact@nicolas-t.ovh">Contact</a>
			</div>
			<div class="ui grid menu-bottom item">
				<div class="eight wide column">
					<button class="ui mini button inverted" :class="this.locale === 'fr' ? 'primary': ''"
							@click="changeLocale('fr')"><i class="france flag"></i><br>Français
					</button>
				</div>
				<div class="eight wide column">
					<button class="ui mini button inverted" :class="this.locale !== 'fr' ? 'primary': ''"
							@click="changeLocale('en')"><i class="gb flag"></i><br>English
					</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: "Sidebar",
	data: function () {
		return {
			locale: this.$parent.$data.locale,
			description: "Ingénieur Sécurité et Qualité des Réseaux • Développeur • Auteur"
		}
	},
	methods: {
		changeLocale: function (locale) {
			this.$emit('change-locale', {locale: locale})
			this.updateLocale(locale)
		},
		updateLocale: function (locale) {
			this.locale = locale
		},
		loadDescription: function () {
			if (this.locale !== 'fr') {
				this.description = "Security & Quality of networks Engineer • Developer • Author"
			} else {
				this.description = "Ingénieur Sécurité et Qualité des Réseaux • Développeur • Auteur"
			}
		}
	},
	created() {
		this.loadDescription()
	},
	watch: {
		locale: function () {
			this.loadDescription()
		}
	}
}
</script>

<style scoped>
.dark-grey {
	background-color: #333333 !important;
}

div.photo {
	display: flex !important;
	justify-content: center;
}

img.photo {
	height: 150px;
	width: 150px;
	border: 5px solid #1a4692;
	border-radius: 50%;
	box-shadow: 0 0 15px 5px rgba(255, 255, 255, 0.25);
}

h1 {
	text-align: center;
	margin-top: 5px !important;
	color: #ffffff;
}

.description {
	text-align: center;
	font-weight: 300;
	color: #ffffff;
}

.description-item:after,
.ui.vertical.menu .scroll .item:last-child:after {
	position: absolute;
	content: '';
	bottom: 0;
	left: 0;
	width: 100%;
	height: 1px;
	background: rgba(255, 255, 255, .08);;
}

.scroll-menu {
	height: calc(100% - 330px);
	overflow: hidden;
}

.scroll {
	height: calc(100% - 90px);
	overflow: auto;
}

.ui.menu .scroll-menu .scroll .item {
	text-align: center;
}

.menu-bottom {
	position: absolute !important;
	bottom: 0;
}

.item button, .item button i {
	transition: .3s !important;
}

.item button:hover {
	transform: scale(1.15);
}

.item button:hover i {
	transform: scale(1.5);
}

@media (max-width: 768px) {
	.menu {
		display: none !important;
	}
}
</style>