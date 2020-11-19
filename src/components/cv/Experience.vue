<template>
	<div>
		<h1>Mes expériences professionnelles</h1>
		<div id="timeline-content">
			<ul class="timeline">
				<li class="event" v-for="experience in experiences" :key="experience.index" :data-date="`${dateRangeDisplay(experience.dateBegin,
				experience.dateEnd)}`">
					<h3>{{ experience.title }}</h3>
					<div class="ui fluid card">
						<div class="content">
							<img class="right floated mini ui image" :src="experience.corporation.logo">
							<div class="header">
								{{ experience.corporation.name }}
							</div>
							<div class="meta">
								{{ experience.corporation.location }} <i class="flag" :class="experience.corporation.flag"></i>
							</div>
							<div class="description">
								{{ experience.corporation.description }}
							</div>
						</div>
					</div>
					<ul>
						<li v-for="item in experience.description" v-html="item" :key="item.index"></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</template>

<script>
import moment from 'moment'

export default {
	name: "CVExperiences",
	props: ["locale"],
	data: function () {
		return {
			experiences: []
		}
	},
	mounted: function () {
		this.displayTitle()
		this.fetchMyInfos()
	},
	methods: {
		displayTitle: function () {
			if (this.locale === "fr") {
				document.title = `Expériences professionnelles | ${this.$parent.$data.title}`
			} else {
				document.title = `Professional experiences | ${this.$parent.$data.title}`
			}
		},
		fetchMyInfos: function () {
			$.ajax({
				url: `./assets/${this.locale}/cv/experiences.json`,
				type: 'GET',
				dataType: "json",
				success: (response) => {
					this.experiences = response
				},
				error: (response, status, error) => {
					this.experiences = []
					throw new Error("Error when fetching the information: ", error)
				}
			})
		},
		dateRangeDisplay: function(begin, end){
			return `${this.$options.filters.date(begin, this.locale)} - ${this.$options.filters.date(end, this.locale)}`
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
/* Import */
@import url('https://fonts.googleapis.com/css?family=Chivo:300,300i,400,400i,700,700i,900,900i');
/* Variables */

#timeline-content {
	margin-top: 50px;
	margin-left: 190px;
	text-align: center;
}

/* Timeline */
.timeline {
	border-left: 4px solid #004ffc;
	border-bottom-right-radius: 4px;
	border-top-right-radius: 4px;
	margin: 50px auto;
	letter-spacing: 0.5px;
	position: relative;
	line-height: 1.4em;
	font-size: 1.03em;
	padding: 50px;
	list-style: none;
	text-align: left;
	/*max-width: 30%;*/
}

.timeline h2,
.timeline h3 {
	letter-spacing: 1.5px;
	font-weight: 400;
	font-size: 1.4em;
	color: #1a4692;
	font-family: 'Chivo', sans-serif;
}

.timeline .event {
	border-bottom: 1px dashed rgba(0, 0, 0, 0.1);
	padding-bottom: 25px;
	margin-bottom: 50px;
	position: relative;
}

.timeline .event:last-of-type {
	padding-bottom: 0;
	margin-bottom: 0;
	border: none;
}

.timeline .event:before,
.timeline .event:after {
	position: absolute;
	display: block;
	top: 0;
}

.timeline .event:before {
	left: -240px;
	content: attr(data-date);
	text-align: right;
	font-size: 0.9em;
	min-width: 120px;
}

.timeline .event:after {
	box-shadow: 0 0 0 4px #004ffc;
	left: -57.85px;
	background: #313534;
	border-radius: 50%;
	height: 11px;
	width: 11px;
	content: "";
	top: 5px;
}

.ui.cards {
	margin-bottom: 5px;
}
</style>