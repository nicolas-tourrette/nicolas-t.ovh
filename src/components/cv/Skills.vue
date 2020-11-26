<template>
	<div>
		<h1>{{ $t('Resume.Skills.Title') }}</h1>
		<div class="ui teal progress" v-for="skill in skills" :key="skill.index">
			<div class="bar" :style="{width:  skill.percentage + '%'}">
				<div class="progress">{{skill.percentage}}%</div>
			</div>
			<div class="label">{{ skill.name }}</div>
		</div>
	</div>
</template>

<script>
export default {
	name: "CVSkills",
	props: ["locale"],
	data: function () {
		return {
			skills: []
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
				document.title = `Compétences | ${this.$parent.$data.title}`
			} else {
				document.title = `Skills | ${this.$parent.$data.title}`
			}
		},
		fetchMyInfos: function () {
			$.ajax({
				url: `./assets/${this.locale}/cv/skills.json`,
				type: 'GET',
				dataType: "json",
				success: (response) => {
					this.skills = response
				},
				error: (response, status, error) => {
					this.skills = []
					throw new Error("Error when fetching the information: ", error)
				}
			})
		}
	},
	watch: {
		locale: function () {
			this.displayTitle()
			this.fetchMyInfos()
		},
	}
}
</script>

<style scoped>
.ui.progress .bar>.progress {
	left: 50%;
	right: auto;
}
</style>