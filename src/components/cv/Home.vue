<template>
	<div>
		<h1>{{ $t('Resume.Home.Title') }}</h1>
		<h4>{{ infos.description }}</h4>
		<div class="ui icon message" :class="infos.professional.status">
			<i class="icon" :class="infos.professional.icon"></i>
			<div class="content">
				<div class="header text-center">{{ infos.professional.short }}</div>
				<p v-html="infos.professional.description"></p>
			</div>
		</div>
		<h3 v-html="infos.info"></h3>
		<p v-html="infos.homeInfo"></p>
		<div class="ui two cards">
			<div class="card">
				<div class="content">
					<div class="header">{{ $t('Resume.Home.ContactMe') }}</div>
					<div class="description">
						<div class="row">
							<div><i class="icon home"></i></div>
							<div v-html="infos.contact.address"></div>
						</div>
						<div class="row">
							<div><i class="icon phone"></i></div>
							<div>{{ infos.contact.phone }}</div>
						</div>
						<div class="row">
							<div><i class="icon envelope"></i></div>
							<div><a :href="'mailto:' + infos.contact.mail">{{ infos.contact.mail }}</a></div>
						</div>
						<div class="row">
							<div><i class="icon linkedin"></i></div>
							<div><a :href="infos.contact.linkedin">{{ $t("Resume.Home.LinkedInProfileTitle") }}</a></div>
						</div>
					</div>
				</div>
			</div>
			<div class="card">
				<div class="content">
					<div class="header">{{ $t('Resume.Home.PersonalInfo') }}</div>
					<div class="description">
						<div class="row">
							<div><i class="icon heart"></i></div>
							<div>{{ infos.personal.status }}</div>
						</div>
						<div class="row">
							<div><i class="icon calendar"></i></div>
							<div>{{ infos.personal.birthday | date(this.locale) }}</div>
						</div>
						<div class="row">
							<div><i class="icon car"></i></div>
							<div>{{ infos.personal.licence }}</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<h3>{{ $t('Resume.Home.Biography') }}</h3>
		<p v-for="paragraphe in infos.biography" :key="paragraphe.key" v-html="paragraphe"></p>
		<h3>{{ $t('Resume.Home.Strengths') }}</h3>
		<span class="ui orange label" v-for="strength in infos.strengths" :key="strength.key">{{ strength }}</span>
	</div>
</template>

<script>
import moment from 'moment'

export default {
	name: "CVHome",
	props: ["locale"],
	data: function () {
		return {
			infos: {
				description: "",
				info: "",
				homeInfo: "",
				professional: {
					status: "",
					icon: "",
					short: "",
					description: ""
				},
				personal: {
					status: "",
					birthday: "1998-08-12",
					licence: ""
				},
				contact: {
					mail: "",
					phone: "",
					address: "",
					linkedin: "https://www.linkedin.com/in/nicolas-tourrette"
				},
				biography: [],
				strengths: []
			}
		}
	},
	created: function () {
		this.fetchMyInfos()
	},
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
		},
		fetchMyInfos: function () {
			$.ajax({
				url: `./assets/${this.locale}/cv/me.json`,
				type: 'GET',
				dataType: "json",
				success: (response) => {
					this.infos = response
				},
				error: (response, status, error) => {
					this.infos = []
					throw new Error("Error when fetching the information: ", error)
				}
			})
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
			this.fetchMyInfos()
		}
	}
}
</script>

<style scoped>
.ui.icon.message .content {
	margin-left: 0 !important;
}

.description .row {
	display: flex;
	align-items: center;
}

.description .row:not(:last-child){
	margin-bottom: 7px;
}

.description .row div:first-child {
	margin-right: 10px;
}

@media (max-width: 768px){
	.ui.icon.message .content {
		margin-left: 0;
		margin-top: 0;
	}
}
</style>