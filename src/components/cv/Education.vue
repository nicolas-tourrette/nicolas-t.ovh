<template>
	<div>
		<h1>Ma formation</h1>
		<div id="timeline-content">
			<ul class="timeline">
				<li class="event" v-for="formation in education" :key="formation.index" :data-date="formation.dateBegin + ' - ' + formation.dateEnd">
					<h3>{{ formation.title }}</h3>
					<div class="ui equal width grid">
						<div class="column" v-for="school in formation.schools" :key="school.index">
							<div class="ui fluid card">
								<div class="content">
									<img class="right floated mini ui image" :src="school.logo">
									<div class="header">
										{{ school.name }}
									</div>
									<div class="meta">
										{{ school.location }}
									</div>
									<div class="description">
										{{ school.description }}
									</div>
								</div>
							</div>
						</div>
					</div>
					<ul>
						<li v-for="item in formation.description" v-html="item" :key="item.index"></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</template>

<script>
export default {
	name: "CVEducation",
	props: ["locale"],
	data: function () {
		return {
			education: []
		}
	},
	mounted: function () {
		this.displayTitle()
		this.fetchMyInfos()
	},
	methods: {
		displayTitle: function () {
			if (this.locale === "fr") {
				document.title = `Formation | ${this.$parent.$data.title}`
			} else {
				document.title = `Education | ${this.$parent.$data.title}`
			}
		},
		fetchMyInfos: function () {
			$.ajax({
				url: `./assets/${this.locale}/cv/education.json`,
				type: 'GET',
				dataType: "json",
				success: (response) => {
					this.education = response
				},
				error: (response, status, error) => {
					this.education = []
					throw new Error("Error when fetching the information: ", error)
				}
			})
		}
	},
	filters: {},
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
	margin-left: 170px;
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
	left: -217.5px;
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

.ui.equal.grid {
	margin-bottom: 5px;
}
</style>