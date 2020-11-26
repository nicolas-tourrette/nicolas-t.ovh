<template>
	<div>
		<h1>{{ $t('Resume.Interests.Title') }}</h1>
		<div class="ui equal width grid">
			<div class="column" v-for="interest in interests" :key="interest.key">
				<div class="ui fluid card">
					<div class="content">
						<div class="header"><i :class="'icofont-' + interest.type"></i> {{ interest.title }}</div>
<!--						<div class="meta">Ami</div>-->
						<div class="description" v-html="interest.description"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: "CVInterests",
	props: ["locale"],
	data: function () {
		return {
			interests: []
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
				url: `./assets/${this.locale}/cv/interests.json`,
				type: 'GET',
				dataType: "json",
				success: (response) => {
					this.interests = response
				},
				error: (response, status, error) => {
					this.interests = []
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
.ui.equal.grid {
	margin-bottom: 5px;
}
</style>