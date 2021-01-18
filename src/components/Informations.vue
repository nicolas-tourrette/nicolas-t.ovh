<template>
	<div class="container">
		<h1 class="ui header blue">
			<i class="icon icofont-info-circle"></i>
			<div class="content">
				{{ $t('Information.Page.Title') }}
				<div class="sub header">
					{{ $t('Information.Page.Subtitle') }}<br>
					<small>{{ $t('Information.Page.UpdateText') }} {{ this.$parent.$data.lastContentUpdate | date(this.locale) }}.</small>
				</div>
			</div>
		</h1>
		<div class="ui stackable grid">
			<div class="eight wide column">
				<h3>{{ $t('Information.Page.Availability.Title') }}</h3>
				<p v-html="$t('Information.Page.Availability.Texts.Explanation')"></p>
				<p><span v-html="$t('Information.Page.Availability.Texts.Uptime')"></span> {{ uptime }}.</p>
				<h3>{{ $t('Information.Page.Monitoring.Title') }}</h3>
				<p v-html="$t('Information.Page.Monitoring.Text')"></p>
				<h3>{{ $t('Information.Page.Asking.Title') }}</h3>
				<p v-html="$t('Information.Page.Asking.Text')"></p>
                <h3>{{ $t('Information.Page.SecureCom.Title') }}</h3>
				<p v-html="$t('Information.Page.SecureCom.Text')"></p>
			</div>
			<div class="eight wide column">
				<h3>{{ $t('Information.Page.VersionsHistory.Title') }}</h3>
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