<template>
  <div class="main-content">
    <breadcumb :page="$t('userList')" :folder="$t('userManage')" />

    <b-tabs pills align="end" v-model="tabIndex">
      <b-tab :title="$t('userList')" active @click="clearData">
        <b-card :title="$t('userList')">
          <b-row>
            <b-col md="12">
              <b-card class="mb-30">
                <b-row align-v="center">
                  <b-col md="2">
                    <b-form-group
                      id="input-group-1"
                      label="UID"
                      label-for="input-1"
                    >
                      <b-form-input
                        id="input-1"
                        type="text"
                        required
                        :placeholder="$t('Enter') + 'UID'"
                        v-model="searchUID"
                      ></b-form-input>
                    </b-form-group>
                  </b-col>

                  <b-col md="2">
                    <b-form-group
                      id="input-group-1"
                      :label="$t('username')"
                      label-for="input-1"
                    >
                      <b-form-input
                        id="input-1"
                        type="text"
                        required
                        :placeholder="$t('Enter') + $t('username')"
                        v-model="searchUsername"
                      ></b-form-input>
                    </b-form-group>
                  </b-col>

                  <b-col md="2" class="mt-3 mt-md-0">
                    <b-form-group
                      id="input-group-2"
                      :label="$t('mobile')"
                      label-for="input-2"
                    >
                      <b-form-input
                        id="input-2"
                        type="text"
                        required
                        :placeholder="$t('Enter') + $t('mobile')"
                        v-model="searchPhone"
                      ></b-form-input>
                    </b-form-group>
                  </b-col>

                  <b-col md="1" class="mt-3 mt-md-0">
                    <b-button variant="primary" @click="onSearch">{{
                      $t("search")
                    }}</b-button>
                  </b-col>
                  <b-col md="1" class="mt-3 mt-md-0" v-if="canClear">
                    <b-button variant="danger" @click="onCancel">{{
                      $t("clear")
                    }}</b-button>
                  </b-col>
                </b-row>
              </b-card>
            </b-col>
          </b-row>
          <vue-good-table
            id="table"
            mode="remote"
            @on-page-change="onPageChange"
            @on-search="onSearch"
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
              <span v-if="props.column.field == 'contact_number'">
                <span v-if="props.row.contact_number">
                  {{
                    props.row.country.country_code + props.row.contact_number
                  }}
                </span>
              </span>
              <span v-else-if="props.column.field == 'user_group_id'">
                <span v-if="$i18n.locale == 'en'">
                  {{ props.row.package.package_name_en }}
                </span>
                <span v-else>{{ props.row.package.package_name }}</span>
              </span>
              <span v-else-if="props.column.field == 'wr'">
                <span v-if="props.row.wr" style="color: green">
                  <i class="fa fa-check"></i>
                </span>
                <span v-else style="color: red">
                  <i class="fa fa-remove"></i>
                </span>
              </span>
              <span v-else-if="props.column.field == 'wt'">
                <span v-if="props.row.wt" style="color: green">
                  <i class="fa fa-check"></i>
                </span>
                <span v-else style="color: red">
                  <i class="fa fa-remove"></i>
                </span>
              </span>
              <span v-else-if="props.column.field == 'rb'">
                <span v-if="props.row.rb" style="color: green">
                  <i class="fa fa-check"></i>
                </span>
                <span v-else style="color: red">
                  <i class="fa fa-remove"></i>
                </span>
              </span>
              <span v-else-if="props.column.field == 'created_at'">
                {{ processDate(props.row.created_at) }}
              </span>
              <span v-else-if="props.column.field == 'action'">
                <button
                  type="button"
                  class="btn btn-default btn-edit"
                  v-b-popover.hover.top="$t('editUser')"
                  @click="editUser(props.row)"
                >
                  <i class="fa fa-pencil"></i>
                </button>
                <button
                  type="button"
                  class="btn btn-default btn-push mx-1 px-2"
                  v-b-popover.hover.top="$t('updatePwd')"
                  @click="showModal(props.row)"
                >
                  <i class="fa fa-shield"></i>
                </button>
                <button
                  type="button"
                  class="btn btn-default btn-wallet"
                  v-b-popover.hover.top="$t('walletRecord')"
                  @click="showWallet(props.row.username)"
                >
                  <i class="fa fa-money"></i>
                </button>
              </span>
            </template>
          </vue-good-table>

          <div class="align-items-center mobile-adjust">
            <div
              v-if="totalRecords > 0"
              class="
                d-flex
                flex-wrap
                align-items-center
                justify-content-start
                mt-3
              "
            >
              <p class="text-light text-16 mr-2">{{ $t("total") }}</p>
              <p class="text-muted text-16" style="font-weight: bold">
                {{ totalRecords }}
              </p>
            </div>
            <div v-else></div>
            <div
              class="d-flex flex-wrap align-items-center justify-content-end"
            >
              <b-pagination
                class="pagi-margin pt-3"
                v-model="pageNumber"
                :total-rows="totalRecords"
                :per-page="10"
                :first-text="$t('first')"
                :prev-text="$t('prev')"
                :next-text="$t('next')"
                :last-text="$t('last')"
                @input="loadItems()"
              >
              </b-pagination>

              <b-input-group class="ml-3" style="width: 160px">
                <b-form-input
                  v-model="pageNumber"
                  :placeholder="$t('PageNo')"
                ></b-form-input>
                <b-input-group-append>
                  <b-button
                    variant="primary"
                    @keypress="loadItems()"
                    @click="loadItems()"
                    >{{ $t("go") }}</b-button
                  >
                </b-input-group-append>
              </b-input-group>
            </div>
          </div>
        </b-card>
      </b-tab>

      <b-tab
        :title="$t('editUser')"
        :title-item-class="{ hiddenClass: !canEdit }"
      >
        <b-card :title="$t('editUser')">
          <b-row align-h="center">
            <b-col md="8 mb-30">
              <b-form v-on:submit.prevent="updateUser">
                <div class="form-group row">
                  <label for="username2" class="col-sm-2 col-form-label">{{
                    $t("username")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="email"
                      class="form-control"
                      id="username"
                      v-model="username"
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="d_password" class="col-sm-2 col-form-label">{{
                    $t("password")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="d_password"
                      v-model="password"
                      readonly
                    />
                  </div>
                </div>
                <!-- <div class="form-group row">
                  <label for="mobile_no2" class="col-sm-2 col-form-label">{{
                    $t("mobile")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="mobile_no2"
                      v-model="contact_number"
                      required
                    />
                  </div>
                </div> -->
                <div class="form-group row">
                  <label for="country" class="col-sm-2 col-form-label">{{
                    $t("country")
                  }}</label>
                  <div class="col-sm-10">
                    <b-form-select
                      v-model="country"
                      :options="countryOptions"
                      id="country"
                    >
                    </b-form-select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="package" class="col-sm-2 col-form-label">{{
                    $t("package")
                  }}</label>
                  <div class="col-sm-10">
                    <b-form-select
                      v-model="packageType"
                      :options="selectOptions"
                      id="package"
                    >
                    </b-form-select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="wr" class="col-sm-2 col-form-label">{{
                    $t("wr")
                  }}</label>
                  <div class="col-sm-10 py-2">
                    <label class="switch switch-primary mr-3">
                      <input type="checkbox" v-model="wr" />
                      <span class="slider"></span>
                    </label>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="wt" class="col-sm-2 col-form-label">{{
                    $t("wt")
                  }}</label>
                  <div class="col-sm-10 py-2">
                    <label class="switch switch-primary mr-3">
                      <input type="checkbox" v-model="wt" />
                      <span class="slider"></span>
                    </label>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="rb" class="col-sm-2 col-form-label">{{
                    $t("rb")
                  }}</label>
                  <div class="col-sm-10 py-2">
                    <label class="switch switch-primary mr-3">
                      <input type="checkbox" v-model="rb" />
                      <span class="slider"></span>
                    </label>
                  </div>
                </div>
                <div class="form-group row justify-content-end">
                  <div class="col-sm-12">
                    <div class="mt-4 float-right">
                      <b-button type="submit" class="m-1" variant="primary">{{
                        $t("update")
                      }}</b-button>
                    </div>
                  </div>
                </div>
              </b-form>
            </b-col>
          </b-row>
        </b-card>
      </b-tab>

      <b-tab
        :title="$t('walletRecord') + '(' + searchUsernameWallet + ')'"
        :title-item-class="{ hiddenClass: !canShow }"
      >
        <b-row>
          <b-col md="12">
            <b-card class="mb-30">
              <b-row align-v="center">
                <b-col md="2" class="mt-3 mt-md-0">
                  <b-form-group
                    id="walletType"
                    :label="$t('wallet')"
                    label-for="walletType"
                  >
                    <b-form-select
                      v-model="selectWalletType"
                      :options="walletOptions"
                      @change="showWallet(searchUsernameWallet)"
                      id="walletType"
                    >
                    </b-form-select>
                  </b-form-group>
                </b-col>

                <b-col md="3" class="mt-3 mt-md-0">
                  <b-form-group
                    id="input-group-2"
                    :label="$t('from')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      type="date"
                      v-model="from"
                    ></b-form-input>
                  </b-form-group>
                </b-col>

                <b-col md="3" class="mt-3 mt-md-0">
                  <b-form-group
                    id="input-group-2"
                    :label="$t('to')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      type="date"
                      v-model="to"
                    ></b-form-input>
                  </b-form-group>
                </b-col>

                <b-col md="1" class="mt-3 mt-md-0">
                  <b-button variant="primary" @click="onSearchWallet">{{
                    $t("search")
                  }}</b-button>
                </b-col>
                <b-col md="1" class="mt-3 mt-md-0" v-if="canClearWallet">
                  <b-button variant="danger" @click="onCancelWallet">{{
                    $t("clear")
                  }}</b-button>
                </b-col>
              </b-row>
            </b-card>
          </b-col>
        </b-row>
        <b-card :title="$t('totalBalance') + totalBalance">
          <vue-good-table
            id="table"
            mode="remote"
            @on-page-change="onWalletPageChange"
            @on-search="onSearch"
            :totalRows="totalWalletRecords"
            :isLoading="isLoading"
            :columns="walletLabel"
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
              setCurrentPage: walletPageNumber,
            }"
            styleClass="tableOne vgt-table table-striped"
            :selectOptions="{
              enabled: false,
              selectionInfoClass: 'table-alert__box',
            }"
            :rows="walletRows"
          >
            <!-- <div slot="table-actions" class="mb-3">
        <b-button variant="primary" class="btn-rounded"> Add Button </b-button>
      </div> -->

            <template slot="table-row" slot-scope="props">
              <span v-if="props.column.field == 'detail'">
                <span v-if="$i18n.locale == 'zh'">
                  {{ props.row.detail }}
                </span>
                <span v-else>
                  {{ props.row.detailen }}
                </span>
              </span>
              <span v-else-if="props.column.field == 'found'">
                <span v-if="props.row.out_type == 1" style="color: red">
                  -{{ props.row.found }}
                </span>
                <span v-else style="color: green">
                  +{{ props.row.found }}
                </span>
              </span>
              <span v-else-if="props.column.field == 'created_at'">
                {{ props.row.created_at }}
              </span>
            </template>
          </vue-good-table>

          <div class="align-items-center mobile-adjust">
            <div
              v-if="totalWalletRecords > 0"
              class="
                d-flex
                flex-wrap
                align-items-center
                justify-content-start
                mt-3
              "
            >
              <p class="text-light text-16 mr-2">{{ $t("total") }}</p>
              <p class="text-muted text-16" style="font-weight: bold">
                {{ totalWalletRecords }}
              </p>
            </div>
            <div v-else></div>

            <div
              class="d-flex flex-wrap align-items-center justify-content-end"
            >
              <b-pagination
                class="pagi-margin pt-3"
                v-model="walletPageNumber"
                :total-rows="totalWalletRecords"
                :per-page="10"
                :first-text="$t('first')"
                :prev-text="$t('prev')"
                :next-text="$t('next')"
                :last-text="$t('last')"
                @input="showWallet(searchUsernameWallet)"
              >
              </b-pagination>

              <b-input-group class="ml-3" style="width: 160px">
                <b-form-input
                  v-model="walletPageNumber"
                  :placeholder="$t('PageNo')"
                ></b-form-input>
                <b-input-group-append>
                  <b-button
                    variant="primary"
                    @keypress="showWallet(searchUsernameWallet)"
                    @click="showWallet(searchUsernameWallet)"
                    >{{ $t("go") }}</b-button
                  >
                </b-input-group-append>
              </b-input-group>
            </div>
          </div>
        </b-card>
      </b-tab>
    </b-tabs>
    <b-modal
      id="modal-1"
      size="md"
      centered
      :title="$t('updatePwd')"
      :hide-footer="true"
    >
      <b-tabs pills>
        <b-tab :title="$t('password')" active @click="clearData" class="m-0">
          <b-form class="mx-5" v-on:submit.prevent="updatePwd">
            <b-row align-h="center">
              <b-col md="12 my-30">
                <div class="form-group row">
                  <label for="title2" class="col-sm-3 col-form-label">{{
                    $t("username")
                  }}</label>
                  <div class="col-sm-9">
                    <input
                      type="text"
                      class="form-control"
                      id="title2"
                      v-model="username"
                      readonly
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="password" class="col-sm-3 col-form-label">{{
                    $t("password")
                  }}</label>
                  <div class="col-sm-9">
                    <input
                      type="password"
                      class="form-control"
                      id="password"
                      v-model="password"
                      required
                    />
                  </div>
                </div>
                <!-- <div class="form-group row">
              <label for="password" class="col-sm-3 col-form-label">{{
                $t("password2")
              }}</label>
              <div class="col-sm-9">
                <input
                  type="password"
                  class="form-control"
                  id="password"
                  v-model="password2"
                  required
                />
              </div>
            </div> -->
                <div class="form-group row justify-content-end">
                  <div class="col-sm-12">
                    <div class="mt-4 float-right">
                      <b-button type="submit" class="m-1" variant="primary">{{
                        $t("update")
                      }}</b-button>
                    </div>
                  </div>
                </div>
              </b-col>
            </b-row>
          </b-form>
        </b-tab>

        <b-tab :title="$t('password2')" @click="clearData" class="m-0">
          <b-form class="mx-5" v-on:submit.prevent="updatePwd2">
            <b-row align-h="center">
              <b-col md="12 my-30">
                <div class="form-group row">
                  <label for="title2" class="col-sm-3 col-form-label">{{
                    $t("username")
                  }}</label>
                  <div class="col-sm-9">
                    <input
                      type="text"
                      class="form-control"
                      id="title2"
                      v-model="username"
                      readonly
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="password" class="col-sm-3 col-form-label">{{
                    $t("password2")
                  }}</label>
                  <div class="col-sm-9">
                    <input
                      type="password"
                      class="form-control"
                      id="password"
                      v-model="password2"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row justify-content-end">
                  <div class="col-sm-12">
                    <div class="mt-4 float-right">
                      <b-button type="submit" class="m-1" variant="primary">{{
                        $t("update")
                      }}</b-button>
                    </div>
                  </div>
                </div>
              </b-col>
            </b-row>
          </b-form>
        </b-tab>
      </b-tabs>
    </b-modal>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import {
  getUserList,
  getWalletRecord,
  update_pwd,
  update_user,
  country_list,
} from "../../../system/api/api";
import Dialog from "../../../components/dialog.vue";
import { handleError } from "../../../system/handleRes";
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["lang"]),
    walletOptions() {
      return [
        { value: "point1", text: "USDT" },
        { value: "point2", text: this.$t("gasFee") },
        { value: "point3", text: this.$t("gasPanning") },
      ];
    },
    walletLabel() {
      return [
        {
          label: this.$t("id"),
          text: "id",
          field: "id",
          thClass: "gull-th-class",
          value: "id",
          sortable: false,
        },
        {
          label: this.$t("username"),
          text: "username",
          field: "user.username",
          thClass: "gull-th-class",
          value: "username",
          sortable: false,
        },
        {
          label: this.$t("previousBalance"),
          text: "previous",
          field: "previous",
          thClass: "gull-th-class",
          value: "previous",
          sortable: false,
        },
        {
          label: this.$t("founds"),
          text: "found",
          field: "found",
          thClass: "gull-th-class",
          value: "found",
          sortable: false,
        },
        {
          label: this.$t("currentBalance"),
          text: "current",
          field: "current",
          thClass: "gull-th-class",
          value: "current",
          sortable: false,
        },
        {
          label: this.$t("detail"),
          text: "detail",
          field: "detail",
          thClass: "gull-th-class",
          value: "detail",
          sortable: false,
        },
        {
          label: this.$t("created_at"),
          text: "created_at",
          field: "created_at",
          thClass: "gull-th-class",
          value: "created_at",
          sortable: false,
        },
      ];
    },
    columns() {
      return [
        {
          label: this.$t("id"),
          text: "id",
          field: "id",
          thClass: "gull-th-class",
          value: "id",
          sortable: false,
        },
        {
          label: this.$t("username"),
          text: "username",
          field: "username",
          thClass: "gull-th-class",
          value: "username",
          sortable: false,
        },
        {
          label: this.$t("sponsorname"),
          text: "sponsorName",
          field: "sponsor.username",
          thClass: "gull-th-class",
          value: "sponsorName",
          sortable: false,
        },
        // {
        //   label: this.$t("email"),
        //   text: "email",
        //   field: "email",
        //   thClass: "gull-th-class",
        //   value: "email",
        //   sortable: false,
        // },
        {
          label: this.$t("password"),
          text: "password",
          field: "d_password",
          thClass: "gull-th-class",
          value: "password",
          sortable: false,
        },
        {
          label: this.$t("password2"),
          text: "password",
          field: "d_password2",
          thClass: "gull-th-class",
          value: "password",
          sortable: false,
        },
        {
          label: this.$t("node_wallet"),
          text: "wallet",
          field: "wallet",
          thClass: "gull-th-class",
          value: "wallet",
          sortable: false,
        },
        {
          label: "USDT",
          text: "USDT",
          field: "point1",
          thClass: "gull-th-class",
          value: "USDT",
          sortable: false,
        },
        {
          label: this.$t("gasFee"),
          text: "gasFee",
          field: "point2",
          thClass: "gull-th-class",
          value: "gasFee",
          sortable: false,
        },
        {
          label: this.$t("gasPanning"),
          text: "gasFee",
          field: "point3",
          thClass: "gull-th-class",
          value: "gasFee",
          sortable: false,
        },
        {
          label: this.$t("package"),
          text: "user_group_id",
          field: "user_group_id",
          thClass: "gull-th-class",
          value: "user_group_id",
          sortable: false,
        },
        {
          label: this.$t("wr"),
          text: "wr",
          field: "wr",
          thClass: "gull-th-class",
          value: "wr",
          sortable: false,
        },
        {
          label: this.$t("wt"),
          text: "wt",
          field: "wt",
          thClass: "gull-th-class",
          value: "wt",
          sortable: false,
        },
        {
          label: this.$t("rb"),
          text: "rb",
          field: "rb",
          thClass: "gull-th-class",
          value: "rb",
          sortable: false,
        },
        {
          label: this.$t("registerDate"),
          text: "created_at",
          field: "created_at",
          thClass: "gull-th-class",
          value: "created_at",
          tdClass: "dateWidth",
          sortable: false,
        },
        {
          label: this.$t("action"),
          field: "action",
          tdClass: "bodyWidth",
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
      username: "",
      password: "",
      password2: "",
      contact_number: "",
      country_id: "",
      user_group_id: "",
      wr: false,
      rb: false,
      wt: false,

      selectWalletType: "point1",
      from: "",
      to: "",
      canClearWallet: false,
      searchUsernameWallet: "",
      totalBalance: 0,
      totalWalletRecords: 0,

      searchUsername: "",
      searchPhone: "",
      searchUID: "",
      isLoading: false,
      canClear: false,
      totalRecords: 0,
      pageNumber: 1,
      walletPageNumber: 1,
      rows: [],
      walletRows: [],
      tabIndex: 0,
      canEdit: false,
      canShow: false,
      packageType: "1",
      country: null,
      countryOptions: [],
      package: [],
      selectOptions: [],
      countryList: [],
    };
  },
  methods: {
    processDate(rawDate) {
      var d = new Date(rawDate);
      var dMinute = d.getMinutes();
      var dHour = d.getHours();
      if (dMinute.toString().length == 1) {
        dMinute = "0" + dMinute;
      }
      if (dHour.toString().length == 1) {
        dHour = "0" + dHour;
      }
      var date =
        d.getFullYear() +
        "-" +
        (d.getMonth() + 1) +
        "-" +
        d.getDate() +
        " " +
        dHour +
        ":" +
        dMinute;
      return date;
    },
    makeToast(variant = null, msg) {
      this.$bvToast.toast(msg, {
        // title: ` ${variant || "default"}`,
        variant: variant,
        solid: true,
      });
    },
    onPageChange(params) {
      this.pageNumber = params.currentPage;
      this.loadItems();
      var container = this.$el.querySelector("#table");
      var top = container.offsetTop;

      window.scrollTo(0, top);
    },

    onWalletPageChange(params) {
      this.walletPageNumber = params.currentPage;
      this.loadItems();
      var container = this.$el.querySelector("#table");
      var top = container.offsetTop;

      window.scrollTo(0, top);
    },
    onSearch() {
      this.pageNumber = 1;
      if (
        this.searchUsername != "" ||
        this.searchPhone != "" ||
        this.searchUID != ""
      ) {
        this.canClear = true;
      }
      this.loadItems();
    },
    onCancel() {
      this.searchUsername = "";
      this.searchPhone = "";
      this.searchUID = "";
      this.canClear = false;
      this.loadItems();
    },

    onSearchWallet() {
      if (this.searchUsernameWallet != "" || this.from != "" || this.to != "") {
        this.canClearWallet = true;
      }
      this.showWallet(this.searchUsernameWallet);
    },
    onCancelWallet() {
      this.from = "";
      this.to = "";
      this.canClearWallet = false;
      this.showWallet(this.searchUsernameWallet);
    },
    clearData() {
      this.canEdit = false;
      this.canShow = false;
      var self = this;
      self.selectedId = null;
    },
    showModal(row) {
      this.$bvModal.show("modal-1");

      var self = this;
      var contentData = row;
      self.username = contentData.username;
    },
    showWallet(username) {
      this.canShow = true;
      this.tabIndex = 2;
      this.searchUsernameWallet = username;
      this.walletRows = [];
      this.totalBalance = 0;
      this.totalWalletRecords = 0;
      this.walletPageNumber = 1;

      var result = getWalletRecord(
        this.selectWalletType,
        username,
        this.from,
        this.to,
        this.walletPageNumber
      );
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          var dataList = value.data.data.record.data;
          self.walletRows = dataList;
          self.totalBalance = value.data.data.balance;
          self.totalWalletRecords = value.data.data.record.total;
          self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    editUser(row) {
      this.canEdit = true;
      var self = this;
      self.tabIndex = 1;
      var contentData = row;
      self.selectedId = contentData.id;
      self.username = contentData.username;
      self.contact_number = contentData.contact_number;
      self.country = contentData.country.id;
      self.password = contentData.d_password;
      self.password2 = contentData.d_password2;
      self.packageType = contentData.package.id;
      self.wr = contentData.wr == 1 ? true : false;
      self.wt = contentData.wt == 1 ? true : false;
      self.rb = contentData.rb == 1 ? true : false;
    },
    updatePwd() {
      let formData = new FormData();
      formData.append("username", this.username);
      formData.append("password", this.password);
      formData.append("pwd_type", "pwd");

      var result = update_pwd(formData);
      var self = this;
      result
        .then(function () {
          self.$refs.msg.makeToast("success", self.$t("successUpdate"));
          self.tabIndex = 0;
          self.rows = [];
          self.canEdit = false;
          self.loadItems();
          self.$bvModal.hide("modal-1");
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });

      this.password = "";
    },
    updatePwd2() {
      let formData = new FormData();
      formData.append("username", this.username);
      formData.append("password", this.password2);
      formData.append("pwd_type", "pwd2");

      var result = update_pwd(formData);
      var self = this;
      result
        .then(function () {
          self.$refs.msg.makeToast("success", self.$t("successUpdate"));
          self.tabIndex = 0;
          self.rows = [];
          self.canEdit = false;
          self.loadItems();
          self.$bvModal.hide("modal-1");
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });

      this.password2 = "";
    },
    updateUser() {
      // e.preventDefault();
      let formData = new FormData();
      formData.append("user_id", this.selectedId);
      formData.append("username", this.username);
      // formData.append("contact_number", this.contact_number);
      formData.append("country_id", this.country);
      formData.append("user_group_id", this.packageType);
      formData.append("wr", this.wr ? 1 : 0);
      formData.append("rb", this.rb ? 1 : 0);
      formData.append("wt", this.wt ? 1 : 0);

      var result = update_user(formData);
      var self = this;
      result
        .then(function (value) {
          if (value.data.success) {
            self.$refs.msg.makeToast("success", self.$t("successUpdate"));
            self.tabIndex = 0;
            self.rows = [];
            self.canEdit = false;
            self.loadItems();
          } else {
            self.$refs.msg.makeToast("warning", self.$t(value.data.message));
          }
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          // self.makeToast("warning", error.response.statusText+", Please Login Again!");
          //   localStorage.removeItem("boostToken");
          //   self.$router.push("/web/admin/sessions/signIn");
        });
    },
    getCountryList() {
      var result = country_list();
      var self = this;
      self.countryOptions = [];
      this.isLoading = true;
      result
        .then(function (value) {
          console.log(value.data);
          self.countryList = value.data.data;
          for (let i = 0; i < value.data.data.length; i++) {
            var jsonObject = {};
            jsonObject["value"] = value.data.data[i].id;
            jsonObject["text"] =
              self.$i18n.locale == "en"
                ? value.data.data[i].name_en
                : value.data.data[i].name;
            self.countryOptions.push(jsonObject);
          }
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          // localStorage.removeItem("boostToken");
          // self.$router.push("/web/admin/sessions/signIn");
          // self.isLoading = false;
        });
    },
    loadItems() {
      console.log(this.pageNumber);
      this.getCountryList();
      var result = getUserList(
        this.pageNumber,
        this.searchUsername,
        this.searchPhone,
        this.searchUID
      );
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          var dataList = value.data.data.user.data;
          console.log(dataList);
          console.log('=================');
          self.rows = dataList;
          self.totalRecords = value.data.data.user.total;
          self.isLoading = false;

          self.selectOptions = [];
          self.package = value.data.data.package;

          for (let i = 0; i < self.package.length; i++) {
            var jsonPackage = {};
            jsonPackage["value"] = self.package[i].id;
            jsonPackage["text"] = self.package[i].package_name;
            self.selectOptions.push(jsonPackage);
          }
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  watch: {
    lang(val) {
      console.log(val);
      var self = this;
      self.selectOptions = [];
      if (val == "en") {
        for (let i = 0; i < self.package.length; i++) {
          var jsonPackageEn = {};
          jsonPackageEn["value"] = self.package[i].id;
          jsonPackageEn["text"] = self.package[i].package_name_en;
          self.selectOptions.push(jsonPackageEn);
        }
      } else {
        for (let i = 0; i < self.package.length; i++) {
          var jsonPackage = {};
          jsonPackage["value"] = self.package[i].id;
          jsonPackage["text"] = self.package[i].package_name;
          self.selectOptions.push(jsonPackage);
        }
      }

      self.countryOptions = [];
      for (let i = 0; i < self.countryList.length; i++) {
        var jsonContry = {};
        jsonContry["value"] = self.countryList[i].id;
        jsonContry["text"] =
          val == "en" ? self.countryList[i].name_en : self.countryList[i].name;
        self.countryOptions.push(jsonContry);
      }
    },
  },
  created() {
    this.loadItems();
  },
};
</script>

<style>
.hiddenClass {
  pointer-events: none;
  display: none;
}

.bodyWidth {
  min-width: 120px;
}

.dateWidth {
  min-width: 100px;
}
</style>