<template>
  <div class="main-content">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <img src="../../../assets/images/digital/right.svg" alt="">
      </a>
      <span>{{ $t("forget_password") }}</span>
    </div>

    <div class="mx-4">
      <b-col lg="12" xl="12" md="12" class="p-0">
        <b-row>
          <b-col cols="6">
            <b-card class="mb-30 o-hidden px-2">
              <b-row align-h="between" align-v="center">
                <div>
                  <h6 class="mb-2 text-muted">
                    {{ $t("direct_quantification") }} {{ $t("active") }}
                  </h6>
                  <h4 class="mb-2 text-muted">
                    {{ direct_active }}
                  </h4>
                </div>
              </b-row>
            </b-card>
          </b-col>
          <b-col cols="6">
            <b-card class="mb-30 o-hidden px-2">
              <b-row align-h="between" align-v="center">
                <div>
                  <h6 class="mb-2 text-muted">
                    {{ $t("direct_quantification") }} {{ $t("not_active") }}
                  </h6>
                  <h4 class="mb-2 text-muted">
                    {{ direct_noactive }}
                  </h4>
                </div>
              </b-row>
            </b-card>
          </b-col>
          <b-col cols="6">
            <b-card class="mb-30 o-hidden px-2">
              <b-row align-h="between" align-v="center">
                <div>
                  <h6 class="mb-2 text-muted">
                    {{ $t("team_quantification") }} {{ $t("active") }}
                  </h6>
                  <h4 class="mb-2 text-muted">
                    {{ team_active }}
                  </h4>
                </div>
              </b-row>
            </b-card>
          </b-col>
          <b-col cols="6">
            <b-card class="mb-30 o-hidden px-2">
              <b-row align-h="between" align-v="center">
                <div>
                  <h6 class="mb-2 text-muted">
                    {{ $t("team_quantification") }} {{ $t("not_active") }}
                  </h6>
                  <h4 class="mb-2 text-muted">
                    {{ team_noactive }}
                  </h4>
                </div>
              </b-row>
            </b-card>
          </b-col>
        </b-row>
      </b-col>
      <b-card :title="$t('my_team')">
        <vue-good-table
          id="table"
          mode="remote"
          @on-page-change="onPageChange"
          :totalRows="totalRecords"
          :isLoading="isLoading"
          :columns="columns"
          :search-options="{
            enabled: false,
            placeholder: 'Search this table',
          }"
          :pagination-options="{
            enabled: false,
            perPageDropdownEnabled: false,
            perPageDropdown: [10],
            dropdownAllowAll: false,
            rowsPerPageLabel: $t('rowPerPage'),
            nextLabel: $t('next'),
            prevLabel: $t('previous'),
            mode: 'pages',
            pageLabel: $t('page'),
            setCurrentPage: pageNumber,
          }"
          styleClass="tableOne vgt-table table-striped"
          :selectOptions="{
            enabled: false,
            selectionInfoClass: 'table-alert__box',
          }"
          :rows="rows"
        >
          <!-- <div slot="table-actions" class="mb-3">
        <b-button variant="primary" class="btn-rounded"> Add Button </b-button>
      </div> -->

          <template slot="table-row" slot-scope="props">
            <span v-if="props.column.field == 'package'">
              <span v-if="$i18n.locale == 'zh'">
                {{ props.row.package.package_name }}
              </span>
              <span v-else>
                {{ props.row.package.package_name_en }}
              </span>
            </span>
            <span v-else-if="props.column.field == 'date'">
              {{ props.row.date }}
            </span>
            <span v-else-if="props.column.field == 'action'">
              <a :href="website + '=' + props.row.date">{{ $t("go_view") }} </a>
            </span>
          </template>
        </vue-good-table>
        <div style="position: relative; margin-top: 20px" class="text-center">
          <b-row align-h="center">
            <b-col cols="6" v-if="current_page != 1">
              <b-button class="" @click="loadItems(current_page - 1)">
                <span class="text-16"> {{ $t("previous") }}</span>
              </b-button>
            </b-col>
            <b-col cols="6" v-if="current_page < last_page">
              <b-button
                class="p-0 border-0"
                @click="loadItems(current_page + 1)"
              >
                <b-card>
                  <span class="text-16"> {{ $t("next") }}</span>
                </b-card>
              </b-button></b-col
            >
          </b-row>
        </div>
      </b-card>
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getTeam } from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["lang"]),
    columns() {
      return [
        {
          label: this.$t("level"),
          text: "package",
          field: "package",
          thClass: "gull-th-class",
          value: "package",
          sortable: false,
        },
        {
          label: this.$t("account"),
          text: "username",
          field: "username",
          thClass: "gull-th-class",
          value: "username",
          sortable: false,
        },
        {
          label: this.$t("team_amount"),
          text: "total_sponsor",
          field: "total_sponsor",
          thClass: "gull-th-class",
          value: "total_sponsor",
          sortable: false,
        },
      ];
    },
  },
  components: {
    Dialog,
  },
  data() {
    return {
      tabIndex: 0,
      selectedId: null,
      isLoading: false,
      totalRecords: 0,
      pageNumber: 1,
      current_page: "",
      last_page: "",
      direct_active: "",
      direct_noactive: "",
      team_active: "",
      team_noactive: "",
      canClear: false,
      rows: [],
    };
  },
  props: ["success"],
  methods: {
    onPageChange(params) {
      this.pageNumber = params.currentPage + 1;
      this.loadItems(this.pageNumber);
      var container = this.$el.querySelector("#table");
      var top = container.offsetTop;

      window.scrollTo(0, top);
    },
    loadItems(pageNumber) {
      var result = getTeam(pageNumber);
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          var dataList = value.data.data.team_list.data;
          self.current_page = value.data.data.team_list.current_page;
          self.last_page = value.data.data.team_list.last_page;
          console.log(value);
          self.direct_active = value.data.data.direct_active;
          self.direct_noactive = value.data.data.direct_noactive;
          self.team_active = value.data.data.team_active;
          self.team_noactive = value.data.data.team_noactive;
          self.rows = dataList;
          self.totalRecords = value.data.data.total;
          // self.wallets = value.data.data.wallet;
          self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  watch: {
    lang(val) {
      var self = this;
      var w = self.wallets;
      self.walletOptions = [];
      if (val == "en") {
        for (var index in self.wallets) {
          var jsonPackageEn = {};
          jsonPackageEn["value"] = w[index].found_type;
          jsonPackageEn["text"] = w[index].comments_en;
          self.walletOptions.push(jsonPackageEn);
        }
      } else {
        for (var index2 in self.wallets) {
          var jsonPackage = {};
          jsonPackage["value"] = w[index2].found_type;
          jsonPackage["text"] = w[index2].comments_cn;
          self.walletOptions.push(jsonPackage);
        }
      }
    },
  },
  created() {
    this.loadItems(this.pageNumber);
  },
};
</script>

<style>
#fileName span {
  white-space: nowrap;
  overflow: hidden;
  display: inline-block;
}
#fileName span:first-child {
  width: 60px;
  text-overflow: ellipsis;
}
#fileName span + span {
  width: 34px;
  direction: rtl;
  text-align: right;
  /* text-overflow: ellipsis; */
}

.upload-hint {
  position: absolute;
  width: 100%;
  height: 100%;
  border-style: dotted;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}

.hiddenClass {
  pointer-events: none;
  display: none;
}

.addressWidth {
  max-width: 200px;
}

.txidWidth {
  max-width: 275px;
}
</style>