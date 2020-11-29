<template>
	<div class="ui top fixed menu">
		<div class="item">
			<img src="../assets/img/personal.jpg">
		</div>
		<div class="header item">Nicolas TOURRETTE</div>
		<div class="ui dropdown item">Menu <i class="dropdown icon"></i>
			<div class="menu">
				<router-link :to="{ name: 'home'}" class="item">{{ $t("Sidebar.Accueil") }}</router-link>
				<router-link :to="{ name: 'news'}" class="item">{{ $t("Sidebar.Actualites") }}</router-link>
				<router-link :to="{ name: 'publications'}" class="item">{{ $t("Sidebar.Publications") }}</router-link>
				<router-link :to="{ name: 'mariage'}" class="item">{{ $t("Sidebar.Mariage") }}</router-link>
				<router-link :to="{ name: 'cv'}" class="item">{{ $t("Sidebar.CV") }}</router-link>
				<router-link :to="{ name: 'infos'}" class="item">{{ $t("Sidebar.Informations") }}</router-link>
				<a class="item" href="mailto:contact@nicolas-t.ovh">Contact</a>
				<div class="ui dropdown item"><i class="icon flag"></i> {{ this.locale === 'fr' ? "Langue" : "Language" }}
					<i class="dropdown icon"></i>
					<div class="menu stackable">
						<a class="item" :class="this.locale === 'fr' ? 'active': ''" @click="changeLocale('fr')">
							<i class="france flag"></i><br>Français
						</a>
						<a class="item" :class="this.locale !== 'fr' ? 'active': ''" @click="changeLocale('en')">
							<i class="gb flag"></i><br>English
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: "MenuMobile",
	data: function () {
		return {
			locale: this.$parent.$data.locale,
		}
	},
	mounted: function () {
		$('.ui.dropdown').dropdown()
	},
	updated: function () {
		this.locale = this.$parent.$data.locale
	},
	methods: {
		changeLocale: function (locale) {
			this.$emit('change-locale', {locale: locale})
			this.locale = locale
		}
	}
}
</script>

<style scoped>
.ui.top.fixed.menu {
	width: 100vw;
	visibility: hidden;
}

@media (max-width: 768px) {
	.ui.top.fixed.menu {
		visibility: visible;
	}
}
</style>