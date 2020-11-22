<template>
	<div class="container">
		<h1 class="ui header blue">
			<i class="icon icofont-info-circle"></i>
			<div class="content">
				Informations
				<div class="sub header">
					Informations sur le site www.nicolas-t.ovh.<br>
					<small>Mise à jour du contenu : {{ this.$parent.$data.lastContentUpdate | date(this.locale) }}.</small>
				</div>
			</div>
		</h1>
		<div class="ui stackable grid">
			<div class="eight wide column">
				<h3>Disponibilité du service</h3>
				<p>
					Le service est disponible 24h/24 sauf interruption dûe à la connexion de l'Utilisateur ou du prestataire de service. <strong>Le
					service est redémarré chaque dimanche à 23h59</strong>. Le service ne sera pas accessible durant la courte durée de ce
					redémarrage.
				</p>
				<p>Le service est <span class="ui green label">UP</span> depuis {{ uptime }}.</p>
				<h3>Monitoring des services</h3>
				<p>
					Le monitoring des services est disponible sur <a href="https://status.nicolas-t.ovh" target="_blank">https://status.nicolas-t
					.ovh</a>.
				</p>
				<h3>Demandes</h3>
				<p>
					Pour toute demande concernant le service, vous pouvez contacter <a href="mailto:postmaster@nicolas-t.ovh">cette adresse</a>. La
					réponse sera faite dans les plus brefs délais.
				</p>
			</div>
			<div class="eight wide column">
				<h3>Historique des versions</h3>
				<div class="ui raised fluid card" v-for="version in this.$parent.$data.versions" :key="version.index">
					<div class="content">
						<div class="header">
							<div class="ui purple label">{{ version.number }}</div>
							{{ version.date | date(locale) }}
						</div>
						<div class="description">
							<div class="items" v-for="item in version.items" :key="item.index">
								<div class="ui label" :class="item.type.toLowerCase()">{{ item.type }}</div>
								<div>{{ item.content }}</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import moment from "moment"

export default {
	name: "Informations",
	props: ['locale'],
	data() {
		return {
			uptime: ""
		}
	},
	created() {
		this.getUptime()
	},
	mounted: function () {
		this.displayTitle()
	},
	methods: {
		displayTitle: function () {
			if (this.locale === "fr") {
				document.title = `Informations | ${this.$parent.$data.title}`
			} else {
				document.title = `Information | ${this.$parent.$data.title}`
			}
		},
		getUptime: function () {
			$.ajax({
				url: "./api/uptime.php",
				type: "GET",
				dataType: "html",
				success: (html) => {
					this.uptime = html
				},
				error: (result, status, error) => {
					console.error("Error " + status + ": " + error);
				}
			});
			setTimeout(this.getUptime, 60000);
		}
	},
	filters: {
		date: (date, locale) => {
			moment.locale(locale)
			return moment(date).format('LL')
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
.ui.header .content .sub.header small {
	font-size: 70%;
}

.card .header {
	display: flex !important;
	flex-direction: row;
	align-items: center;
	margin-bottom: 15px;
}

.card .header .label {
	margin-right: 15px;
}

div.items {
	display: flex;
	flex-direction: row;
}

div.items:not(:last-child) {
	margin-bottom: 10px;
}

div.items .ui.label {
	color: #ffffff !important;
	margin-left: 40px;
	margin-right: 20px;
	width: 100px !important;
	min-width: 100px;
	align-self: center;
	text-align: center;
	font-size: 10px;
	font-weight: normal;
}

div.items .ui.label.new {
	background-color: #28a745 !important;
	border-color: #28a745 !important;
}

div.items .ui.label.added {
	background-color: #b8175a !important;
	border-color: #b8175a !important;
}

div.items .ui.label.fixed {
	background-color: #fd7e14 !important;
	border-color: #fd7e14 !important;
}

div.items .ui.label.improved {
	background-color: #0366d6 !important;
	border-color: #0366d6 !important;
}

div.items .ui.label.updated {
	background-color: #00CAFF !important;
	border-color: #00CAFF !important;
}
</style>