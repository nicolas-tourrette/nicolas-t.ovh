<template>
    <div class="ui basic modal" id="pgp_key">
        <div class="ui icon header">
            <span v-if="key">
                <i class="icon icofont-lock" :class="isValid ? 'green' : 'red'"></i>
            </span>
            {{ $t('PGP.Title') }}
        </div>
        <div class="content">
            <div class="status" v-if="key">
                <div class="ui horizontal label" :class="isValid ? 'green' : 'red'">
                    <span v-if="isValid"><i class="icofont-check-circled"></i> {{ $t('PGP.Validity.True') }}</span>
                    <span v-else><i class="icofont-close-circled"></i> {{ $t('PGP.Validity.False') }}</span>
                </div>
            </div>
            <i18n path="PGP.InformationText" tag="p">
                <template v-slot:email>
                    <i>{{ email }}</i>
                </template>
            </i18n>
            <p>
                {{ $t('PGP.Details.Title') }}
            </p>
            <ul v-if="key">
                <li><strong>{{ $t('PGP.Details.KeyID') }}</strong> : {{ key.id }}</li>
                <li><strong>{{ $t('PGP.Details.Checksum') }}</strong> : {{ key.checkSum }}</li>
                <li>
                    <strong>{{ $t('PGP.Details.ExpirationDate') }}</strong> : {{ key.expiration | date(locale) }}
                </li>
            </ul>
            <p class="text-center">
                <a v-if="key" :href="'./assets/pgp/' + key.id + '.txt'" target="_blank" class="ui button primary">{{ $t('PGP.Links.Download') }}</a>
                <a :href="'https://keys.openpgp.org/search?q=' + email" target="_blank" class="ui button grey">{{ $t('PGP.Links.ViewOPGPServer') }}</a>
            </p>
        </div>
        <div class="actions">
            <div class="ui green ok inverted button">
                <i class="checkmark icon"></i>
                {{ $t('PGP.Buttons.Finish') }}
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";

export default {
    name: "PGP",
    props: ["locale", "email"],
    data: function () {
        return {
            keys: [
                {
                    email: "nicolas_tourrette@etu.u-bourgogne.fr",
                    id: "E2D854EDE791A6A8",
                    checkSum: "D058D0BAEE1AAC5B191B9E9E2C5995305EC76C07DF21FEC09A295D98F405D6C2",
                    expiration: "2022-01-18"
                }
            ]
        }
    },
    computed: {
        key: function () {
            return this.keys.find((item) => {
                if (item.email === this.email) {
                    return item
                }
            })
        },
        isValid: function () {
            const expirationDate = new Date(this.key.expiration)
            return expirationDate > new Date();
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
}
</script>

<style scoped>
.ui.modal .content {
    margin-left: 0 !important;
}

.ui.modal .status {
    display: flex;
}

.ui.modal .status .label {
    margin-left: auto;
    margin-right: auto;
    margin-bottom: 2.75rem;
    font-size: 20px;
}

a.ui.button:not(:last-child){
    margin-right: 20px;
}
</style>