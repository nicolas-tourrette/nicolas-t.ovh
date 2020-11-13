<template>
	<div class="ui inverted grey vertical footer segment">
		<div class="ui container">
			<div class="ui stackable inverted divided equal height stackable grid">
				<div class="three wide column">
					<h4 class="ui inverted header">
						{{ $t("Footer.APropos.Titre") }}
					</h4>
					<div class="ui inverted link list">
						<router-link :to="{name: 'home'}" class="item">
							<i class="home icon"></i> {{ $t("Footer.APropos.Liens.Accueil") }}
						</router-link>
						<router-link :to="{name: 'news'}" class="item">
							<i class="newspaper outline icon"></i> {{ $t("Footer.APropos.Liens.Actualites") }}
						</router-link>
						<router-link :to="{name: 'publications'}" class="item">
							<i class="newspaper outline icon"></i> {{ $t("Footer.APropos.Liens.Publications") }}
						</router-link>
						<router-link :to="{name: 'cv'}" class="item">
							<i class="id card outline icon"></i> {{ $t("Footer.APropos.Liens.CV") }}
						</router-link>
					</div>
				</div>
				<div class="three wide column">
					<h4 class="ui inverted header">
						{{ $t("Footer.Liens.Titre") }}
					</h4>
					<div class="ui inverted link list">
						<a href="https://cloud.nicolas-t.ovh" target="_blank" class="item">
							<i class="id cloud icon"></i> NCloud
						</a>
						<a href="https://status.nicolas-t.ovh" target="_blank" class="item">
							<i class="id server icon"></i> {{ $t("Footer.Liens.Liens.Statuts") }}
						</a>
						<a href="https://www.github.com/nicolas-tourrette" target="_blank" class="item">
							<i class="id github icon"></i> Github
						</a>
						<a href="#" class="item">
							<i class="id info icon"></i> {{ $t("Footer.Liens.Liens.Informations") }}
						</a>
					</div>
				</div>
				<div class="seven wide column">
					<h4 class="ui inverted header">&copy; Nicolas TOURRETTE 2020.</h4>
					<p>
						{{ $t('Footer.LastUpdate') }} : {{ this.$parent.$data.lastUpdated |
						date(this.$parent.$data.locale) }}.<br>
						Version : {{ this.$parent.$data.version }}
					</p>
					<p>
						{{ $t("Footer.FooterText") }}
					</p>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import moment from 'moment'

export default {
	name: "Footer",
	filters: {
		date: (date, locale) => {
			if (locale === "fr") {
				return moment(date).format('DD/MM/YYYY');
			} else {
				return moment(date).format('M.DD.YYYY');
			}
		}
	}
}
</script>

<style scoped>
.footer {
	padding: 30px !important;
	position: relative;
	bottom: 0;
}

.ui.inverted.grey.segment {
	background-color: #333333 !important;
}

a.item i {
	text-align: center;
	margin-right: 7px !important;
}

a.item {
	transition: transform .3s !important;
}

a.item:hover {
	transform: scale(1.15) translateX(7px);
}
</style>