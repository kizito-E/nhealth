"use strict";
var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
	return typeof t
} : function(t) {
	return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
};
! function n(s, r, o) {
	function d(a, t) {
		if(!r[a]) {
			if(!s[a]) {
				var e = "function" == typeof require && require;
				if(!t && e) return e(a, !0);
				if(c) return c(a, !0);
				throw new Error("Cannot find module '" + a + "'")
			}
			var i = r[a] = {
				exports: {}
			};
			s[a][0].call(i.exports, function(t) {
				var e = s[a][1][t];
				return d(e || t)
			}, i, i.exports, n, s, r, o)
		}
		return r[a].exports
	}
	for(var c = "function" == typeof require && require, t = 0; t < o.length; t++) d(o[t]);
	return d
}({
	1: [function(t, e, a) {}, {}],
	6: [function(t, e, a) {
		var i = t("./vue-edit-camp");
		$(document).on("click", ".camp-action", function() {
			var t = {
					camp_id: $(this).attr("data-id")
				},
				e = $(this).attr("data-action"),
				a = "";
			if("play" === e) a = "/api_v1/admin/camp/play";
			else if("stop" === e) a = "/api_v1/admin/camp/stop";
			else if("delete" === e && confirm("Confirm action?")) a = "/api_v1/admin/camp/delete";
			else if("edit" === e) return void i.init(t.camp_id);
			$.post(a, t, function(t) {
				t.error ? ADFLEX.helpers.notifyError(t.message) : (ADFLEX.helpers.notifySuccess(t.message), $(document).trigger("adflex.dt.reload"))
			}, "json")
		}), $(document).on("click", ".themes-and-bl", function() {
			var t = JSON.parse($(this).attr("data")),
				e = tmpl("themes-and-bl-modal", t);
			$(e).modal()
		})
	}, {
		"./vue-edit-camp": 10
	}],
	7: [function(t, e, a) {
		t("../../datatables")({
			url: "/api_v1/admin/camp/fetch",
			data: {
				filter_user_id: window.filter_user_id
			},
			order: [
				[0, "desc"]
			],
			columns: [{
				data: "id"
			}, {
				data: "user_id"
			}, {
				data: "username",
				render: function(t, e, a) {
					return null === window.filter_user_id ? '<a href="/admin/campaigns?user_id=' + a.user_id + '">' + a.username + "</a>" : a.username
				}
			}, {
				data: "name",
				render: function(t, e, a) {
					var i = ADFLEX.helpers.escapeHtml(t.substr(0, 30));
					return 1 == a.isolated ? i + '  <small class="label label-default"\n                                        style="position: relative; top:-5px"\n                                        data-toggle="tooltip"\n                                        data-title="Isolated campaign">\n                                            <i class="fa fa-lock"></i>\n                                       </small>' : i
				}
			}, {
				data: "theme",
				render: function(t, e, a, i) {
					return tmpl("theme", a)
				}
			}, {
				data: "type",
				render: function(t, e, a, i) {
					return tmpl("type", a)
				}
			}, {
				data: "status",
				render: function(t, e, a, i) {
					return tmpl("status", a)
				}
			}, {
				data: "allowed_site_themes",
				sortable: !1,
				render: function(t, e, a, i) {
					var n = window.ADFLEX.themes,
						s = a.allowed_site_themes.split(","),
						r = {
							count_all_themes: n.length,
							count_enabled_themes: s.length,
							count_disabled_themes: n.length - s.length,
							count_disabled_sites: a.sites_bl.length,
							themes: JSON.stringify({
								name: a.name,
								enabled: s,
								disabled: $(n).not(s).get(),
								sites_bl: a.sites_bl
							})
						};
					return tmpl("allowed-themes", r)
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a, i) {
					return tmpl("actions", a)
				}
			}]
		})
	}, {
		"../../datatables": 87
	}],
	8: [function(t, e, a) {
		isPage("admin/campaigns(.*)") && (t("./dt"), t("./actions"), t("./vue-add-camp"))
	}, {
		"./actions": 6,
		"./dt": 7,
		"./vue-add-camp": 9
	}],
	9: [function(t, e, a) {
		e.exports = new Vue({
			el: "#add-camp",
			data: {
				user_id: null,
				name: "",
				type: "banners",
				start_date: "",
				end_date: "",
				theme: "",
				allowed_site_themes: [],
				hours: [],
				days: [],
				geos: [],
				devs: [],
				platforms: [],
				browsers: [],
				sites_bl: [],
				button_active: !1,
				is_complete: !1
			},
			methods: {
				init: function() {
					var e = this;
					$.getJSON("/api_v1/admin/camp/get_camp_template", function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (e.user_id = null, e.name = t.data.name, e.start_date = t.data.start_date, e.end_date = t.data.end_date, e.theme = t.data.theme, e.allowed_site_themes = t.data.allowed_site_themes, e.hours = t.data.hours, e.days = t.data.days, e.geos = t.data.geos, e.devs = t.data.devs, e.platforms = t.data.platforms, e.browsers = t.data.browsers, e.sites_bl = t.data.sites_bl, e.button_active = !1, e.is_complete = !1, e.$nextTick(function() {
							$(this.$el).find(".selectpicker").selectpicker("refresh"), $(this.$el).find("._datepicker").datepicker({
								autoclose: !0,
								todayBtn: "linked",
								todayHighlight: !0,
								orientation: "auto right",
								format: "yyyy-mm-dd"
							}), $(this.$el).find("._datepicker").on("change", function() {
								$(this).trigger("click")
							})
						}))
					})
				},
				addCamp: function() {
					var e = this;
					this.button_active = !0, $.post("/api_v1/admin/camp/add", this.$data, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1, e.is_complete = !0)
					}, "json")
				},
				closeModal: function() {
					this.init(), $(document).trigger("adflex.dt.reload")
				},
				updateStartDate: function(t) {
					this.start_date = t
				},
				updateEndDate: function(t) {
					this.end_date = t
				}
			},
			computed: {
				countBlSites: function() {
					return this.sites_bl.length
				},
				computedBlSites: {
					get: function() {
						return this.sites_bl.join("\n")
					},
					set: function(t) {
						this.sites_bl = t.split("\n")
					}
				}
			},
			created: function() {
				this.init()
			}
		})
	}, {}],
	10: [function(t, e, a) {
		e.exports = new Vue({
			el: "#edit-camp",
			data: {
				id: null,
				user_id: null,
				name: "",
				type: "",
				start_date: "",
				end_date: "",
				theme: "",
				allowed_site_themes: [],
				hours: [],
				days: [],
				geos: [],
				devs: [],
				platforms: [],
				browsers: [],
				sites_bl: [],
				button_active: !1
			},
			methods: {
				init: function(t) {
					var e = this;
					$.getJSON("/api_v1/admin/camp/get", {
						camp_id: t
					}, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : (e.id = t.data.id, e.user_id = t.data.user_id, e.name = t.data.name, e.type = t.data.type, e.start_date = t.data.start_date, e.end_date = t.data.end_date, e.theme = t.data.theme, e.allowed_site_themes = t.data.allowed_site_themes.split(","), e.hours = t.data.hours.split(","), e.days = t.data.days.split(","), e.geos = t.data.geos.split(","), e.devs = t.data.devs.split(","), e.platforms = t.data.platforms.split(","), e.browsers = t.data.browsers.split(","), e.sites_bl = t.data.sites_bl, e.$nextTick(function() {
							$(this.$el).find("._datepicker").datepicker({
								autoclose: !0,
								todayBtn: "linked",
								todayHighlight: !0,
								orientation: "auto right",
								format: "yyyy-mm-dd"
							}), $(this.$el).find("._datepicker").on("change", function() {
								$(this).trigger("click")
							}), $(this.$el).find(".selectpicker").selectpicker("refresh"), $(this.$el).modal()
						}))
					})
				},
				updateCamp: function() {
					var e = this;
					this.button_active = !0, $.post("/api_v1/admin/camp/update", this.$data, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1
					}, "json")
				},
				closeModal: function() {
					this.id = null, this.user_id = null, this.name = "", this.type = "", this.start_date = "", this.end_date = "", this.theme = "", this.allowed_site_themes = [], this.hours = [], this.days = [], this.geos = [], this.devs = [], this.platforms = [], this.browsers = [], this.sites_bl = [], this.button_active = !1, $(document).trigger("adflex.dt.reload")
				},
				updateStartDate: function(t) {
					this.start_date = t
				},
				updateEndDate: function(t) {
					this.end_date = t
				}
			},
			computed: {
				countBlSites: function() {
					return this.sites_bl.length
				},
				computedBlSites: {
					get: function() {
						return this.sites_bl.join("\n")
					},
					set: function(t) {
						this.sites_bl = t.split("\n")
					}
				}
			}
		})
	}, {}],
	11: [function(t, e, a) {
		if(isPage("admin/dashboard(.*)")) {
			t("../../datatables")({
				url: "/api_v1/record/fetch",
				data: {},
				order: [
					[0, "desc"]
				],
				columns: [{
					data: "id"
				}, {
					data: "beneficiary"
				}, {
					data: "hmo"
				}, {
					data: "sp"
				}, {
					data: "description"
				}, {
					data: "cost",
					render: function(t, e, a) {
						return numeral(a.cost).format("0,0.00")
					}
				}, {
					data: "amount_due",
					render: function(t, e, a) {
						return numeral(a.amount_due).format("0,0.00")
					}
				}, {
					data: "status",
					render: function(t, e, a) {
						return a.status.toUpperCase()
					}
				}, {
					data: "date_initiated"
				}, {
					data: "date_completed"
				}]
			})
		}
		if(isPage("hmo/dashboard(.*)")) {
			t("../../datatables")({
				url: "/api_v1/record/fetch",
				data: {},
				order: [
					[0, "desc"]
				],
				columns: [{
					data: "id"
				}, {
					data: "beneficiary"
				}, {
					data: "sp"
				}, {
					data: "description"
				}, {
					data: "cost",
					render: function(t, e, a) {
						return numeral(a.cost).format("0,0.00")
					}
				}, {
					data: "amount_due",
					render: function(t, e, a) {
						return numeral(a.amount_due).format("0,0.00")
					}
				}, {
					data: "status",
					render: function(t, e, a) {
						return a.status.toUpperCase()
					}
				}, {
					data: null,
					render: function(t, e, a) {
					return tmpl("service-actions", a)
					}
				}, {
					data: "date_initiated"
				}, {
					data: "date_completed"
				}]
			})
		}
		if(isPage("serviceprovider/dashboard(.*)")) {
			t("../../datatables")({
				url: "/api_v1/record/fetch",
				data: {},
				order: [
					[0, "desc"]
				],
				columns: [{
					data: "id"
				}, {
					data: "beneficiary"
				}, {
					data: "hmo"
				}, {
					data: "description"
				}, {
					data: "cost",
					render: function(t, e, a) {
						return numeral(a.cost).format("0,0.00")
					}
				}, {
					data: "amount_due",
					render: function(t, e, a) {
						return numeral(a.amount_due).format("0,0.00")
					}
				}, {
					data: "status",
					render: function(t, e, a) {
						return a.status.toUpperCase()
					}
				}, {
					data: "date_initiated"
				}, {
					data: "date_completed"
				}]
			});
			new Vue({
				el: "#new-service",
				data: {
					user_id: "",
					cost: "",
					amount_due: "",
					description: "",
					status_message: "",
					error: !1
				},
				methods: {
					addService: function() {
						var e = this;
						e.error = !1, $.post("/api_v1/record/create", e.$data, function(t) {
							t.error ? (e.error = !0, e.status_message = t.message) : (e.status_message = t.message)
						}, "json")
					}
				}
			})
		}
		if(isPage("beneficiary/dashboard(.*)")) {
			t("../../datatables")({
				url: "/api_v1/record/fetch",
				data: {},
				order: [
					[0, "desc"]
				],
				columns: [{
					data: "id"
				}, {
					data: "hmo"
				}, {
					data: "sp"
				}, {
					data: "description"
				}, {
					data: "cost",
					render: function(t, e, a) {
						return numeral(a.cost).format("0,0.00")
					}
				}, {
					data: "amount_due",
					render: function(t, e, a) {
						return numeral(a.amount_due).format("0,0.00")
					}
				}, {
					data: "status",
					render: function(t, e, a) {
						return a.status.toUpperCase()
					}
				}, {
					data: null,
					render: function(t, e, a) {
					return tmpl("service-actions", a)
					}
				}, {
					data: "date_initiated"
				}, {
					data: "date_completed"
				}]
			})
		}
		if(isPage("(hmo|beneficiary)/dashboard(.*)")) {
			function s(t, e) {
				$.post("/api_v1/record/update_status/" + e, {
					id: t
				}, function(t) {
					$(document).trigger("adflex.dt.reload")
				}, "json")
			}
			$(document).on("click", ".item-action", function() {
				var t = $(this).attr("data-id"),
					e = $(this).attr("data-action");
				s(t, e)
			})
		}
	}, {
		"../../datatables": 87
	}],
	12: [function(t, e, a) {}, {}],
	15: [function(t, e, a) {
		$(document).on("click", ".payment-details-btn", function() {
			var t = $(this).attr("data-payment-id");
			$.getJSON("/api_v1/admin/payment/get", {
				payment_id: t
			}, function(t) {
				t.error ? ADFLEX.helpers.notifyError(t.message) : $(tmpl("payment-details-modal", t.data)).modal()
			})
		})
	}, {}],
	16: [function(t, e, a) {
		t("../../datatables")({
			url: "/api_v1/admin/payment/fetch",
			data: {
				filter_user_id: window.filter_user_id
			},
			order: [
				[0, "desc"]
			],
			columns: [{
				data: "payment_id"
			}, {
				data: "user_id"
			}, {
				data: "username",
				render: function(t, e, a) {
					return null === window.filter_user_id ? '<a href="/admin/payments?user_id=' + a.user_id + '">' + a.username + "</a>" : a.username
				}
			}, {
				data: "gateway",
				render: function(t, e, a) {
					return tmpl("gateway", a)
				}
			}, {
				data: null,
				render: function(t, e, a) {
					return tmpl("updown", {
						up: 0 < a.amount ? 1 : 0
					})
				}
			}, {
				data: null,
				render: function(t, e, a) {
					return numeral(a.amount).format("0,0.00") + " " + a.currency.toUpperCase()
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a) {
					return tmpl("payment-details", a)
				}
			}, {
				data: "created_at",
				render: function(t) {
					return t + " UTC"
				}
			}]
		})
	}, {
		"../../datatables": 87
	}],
	17: [function(t, e, a) {
		isPage("admin/payments(.*)") && (t("./dt"), t("./actions"))
	}, {
		"./actions": 15,
		"./dt": 16
	}],
	18: [function(i, t, e) {
		$(document).on("click", "[data-payout-id]", function(t) {
			var e = $(this).attr("data-payout-id"),
				a = $(this).attr("data-payout-action");
			"start" === a ? i("./vue-payout-start").init(e) : "end" === a ? i("./vue-payout-end").init(e) : "edit" === a && i("./vue-payout-edit").init(e)
		}), $(document).on("click", "#payout-paypal-account", function() {
			var t = $("#unit-code-modal").find("textarea");
			t.get(0).focus(), t.get(0).select(), copy(t.val())
		}), $("#unit-code-modal").on("click", "textarea", function() {
			$(this).get(0).select()
		})
	}, {
		"./vue-payout-edit": 21,
		"./vue-payout-end": 22,
		"./vue-payout-start": 23
	}],
	19: [function(t, e, a) {
		t("../../datatables")({
			url: "/api_v1/admin/payout/fetch",
			data: {
				filter_user_id: window.filter_user_id
			},
			order: [
				[0, "desc"]
			],
			columns: [{
				data: "id"
			}, {
				data: "user_id"
			}, {
				data: "username",
				render: function(t, e, a) {
					return null === window.filter_user_id ? '<a href="/admin/payouts?user_id=' + a.user_id + '">' + a.username + "</a>" : a.username
				}
			}, {
				data: "status",
				render: function(t, e, a) {
					return "new" == t ? '<span class="label label-info">\n                                New\n                            </span>' : "processing" == t ? '<span class="label label-warning">\n                            <i class="fa fa-fw fa-clock-o"></i>\n                            Processing\n                        </span>' : "success" == t ? '<span class="label label-success">\n                            <i class="fa fa-fw fa-check"></i>\n                            Success\n                        </span>' : "error" == t ? '<span class="label label-danger">\n                            <i class="fa fa-fw fa-times"></i>\n                            Error\n                        </span>' : '<span class="label label-default">\n                            <i class="fa fa-fw fa-question"></i>\n                        </span>'
				}
			}, {
				data: "payout_gateway",
				render: function(t, e, a) {
					return tmpl("gateway", a)
				}
			}, {
				data: "payout_account"
			}, {
				data: null,
				render: function(t, e, a) {
					return numeral(a.amount).format("0,0.00") + " " + a.currency
				}
			}, {
				data: "created_at",
				render: function(t) {
					return t + " UTC"
				}
			}, {
				data: "completed_at",
				render: function(t) {
					return t ? t + " UTC" : " "
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a) {
					return tmpl("payout-actions", a)
				}
			}]
		})
	}, {
		"../../datatables": 87
	}],
	20: [function(t, e, a) {
		isPage("admin/payouts(.*)") && (t("./dt"), t("./actions"))
	}, {
		"./actions": 18,
		"./dt": 19
	}],
	21: [function(t, e, a) {
		e.exports = new Vue({
			el: "#payout-edit",
			data: {
				button_active: !1
			},
			methods: {
				init: function(t) {
					var e = this;
					$.getJSON("/api_v1/admin/payout/get", {
						id: t
					}, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : (e.id = t.data.id, e.payout_account = t.data.payout_account, e.amount = t.data.amount, e.description = t.data.description, $(e.$el).modal({
							keyboard: !1,
							backdrop: "static"
						}))
					})
				},
				closeModal: function() {},
				run: function() {}
			},
			computed: {},
			created: function() {}
		})
	}, {}],
	22: [function(t, e, a) {
		e.exports = new Vue({
			el: "#payout-end",
			data: {
				id: null,
				payout_account: null,
				amount: null,
				currency: null,
				details: null
			},
			methods: {
				init: function(t) {
					var e = this;
					$.getJSON("/api_v1/admin/payout/get", {
						id: t
					}, function(t) {
						t.error ? notifyError(t.message) : (e.id = t.data.id, e.payout_account = t.data.payout_account, e.amount = t.data.amount, e.currency = t.data.currency, e.details = t.data.details, $(e.$el).modal({
							keyboard: !1,
							backdrop: "static"
						}))
					})
				},
				end_success: function() {
					var e = this;
					this.success_button_active = !0, $.post("/api_v1/admin/payout/end_success", this.$data, function(t) {
						t.error ? (notifyError(t.message), e.$refs.end_success.end()) : (notifySuccess(t.message), e.closeModal())
					}, "json")
				},
				end_error: function() {
					var e = this;
					this.error_button_active = !0, $.post("/api_v1/admin/payout/end_error", this.$data, function(t) {
						t.error ? (notifyError(t.message), e.$refs.end_error.end()) : (notifyInfo(t.message), e.closeModal())
					}, "json")
				},
				closeModal: function() {
					this.id = null, this.payout_account = null, this.amount = null, this.amount = null, this.currency = null, this.success_button_active = !1, this.error_button_active = !1, this.$refs.end_error.end(), this.$refs.end_success.end(), $(this.$el).modal("hide"), $(document).trigger("adflex.dt.reload")
				},
				copy: function(e) {
					function t(t) {
						return e.apply(this, arguments)
					}
					return t.toString = function() {
						return e.toString()
					}, t
				}(function(t) {
					this.$refs[t].focus(), this.$refs[t].select(), copy(this[t]), notifySuccess("Copied to clipboard.")
				})
			}
		})
	}, {}],
	23: [function(t, e, a) {
		e.exports = new Vue({
			el: "#payout-start",
			data: {
				id: null,
				payout_account: null,
				amount: null,
				currency: null
			},
			methods: {
				init: function(t) {
					var e = this;
					$.getJSON("/api_v1/admin/payout/get", {
						id: t
					}, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : (e.id = t.data.id, e.payout_account = t.data.payout_account, e.amount = t.data.amount, e.currency = t.data.currency, e.description = t.data.description, $(e.$el).modal({
							keyboard: !1,
							backdrop: "static"
						}))
					})
				},
				start: function() {
					var e = this;
					this.button_active = !0, $.post("/api_v1/admin/payout/start", this.$data, function(t) {
						t.error ? (notifyError(t.message), e.$refs.start.end()) : (notifySuccess(t.message), e.closeModal())
					}, "json")
				},
				closeModal: function() {
					this.id = null, this.payout_account = null, this.amount = null, this.currency = null, this.description = null, this.button_active = !1, this.$refs.start.end(), $(this.$el).modal("hide"), $(document).trigger("adflex.dt.reload")
				},
				copy: function(e) {
					function t(t) {
						return e.apply(this, arguments)
					}
					return t.toString = function() {
						return e.toString()
					}, t
				}(function(t) {
					this.$refs[t].focus(), this.$refs[t].select(), this.$refs.start.end(), copy(this[t]), notifySuccess("Copied to clipboard.")
				})
			}
		})
	}, {}],
	24: [function(t, e, a) {
		e.exports = t(12)
	}, {}],
	25: [function(t, e, a) {
		e.exports = t(12)
	}, {}],
	26: [function(t, e, a) {
		isPage("(admin|hmo|serviceprovider|beneficiary)/settings(.*)") && (t("./dt"), t("./actions"), t("./vue-settings"))
	}, {
		"./actions": 24,
		"./dt": 25,
		"./vue-settings": 27
	}],
	27: [function(t, e, a) {
		e.exports = new Vue({
			el: "#app-settings",
			data: {
				old_password: null,
				new_password: null,
				status_message: "",
				error: !1
			},
			methods: {
				update: function() {
					var e = this;
					e.error = !1, $.post("/api_v1/user/update_password", e.$data, function(t) {
						t.error ? (e.error = !0, e.status_message = t.message) : (e.status_message = t.message)
					}, "json")
				}
			}
		})
	}, {}],
	28: [function(t, e, a) {
		var i = t("./vue-edit-site"),
			n = t("./vue-moderate");
		$(document).on("click", ".site-action", function() {
			var t = {
					site_id: $(this).attr("data-id"),
					csrf: ADFLEX.csrf
				},
				e = $(this).attr("data-action"),
				a = "";
			if("play" === e) a = "/api_v1/admin/site/play";
			else if("stop" === e) a = "/api_v1/admin/site/stop";
			else if("ban" === e) {
				if(t.ban_message = prompt("Specify the reason for the ban.", ""), !t.ban_message) return;
				a = "/api_v1/admin/site/ban"
			} else if("unban" === e) a = "/api_v1/admin/site/unban";
			else {
				if("edit" === e) return void i.init(t.site_id);
				if("moderate" === e) return void n.init(t.site_id)
			}
			$.post(a, t, function(t) {
				t.error ? ADFLEX.helpers.notifyError(t.message) : (ADFLEX.helpers.notifySuccess(t.message), $(document).trigger("adflex.dt.reload"))
			}, "json")
		}), $(document).on("click", ".site-allowed-ad-themes", function() {
			var t = JSON.parse($(this).attr("data")),
				e = tmpl("allowed-ad-themes-tmpl", t);
			$(e).modal()
		})
	}, {
		"./vue-edit-site": 32,
		"./vue-moderate": 33
	}],
	29: [function(t, e, a) {
		t("../../datatables")({
			url: "/api_v1/subscription/fetch",
			data: {},
			order: [
				[0, "desc"]
			],
			columns: [{
				data: "id"
			}, {
				data: "plan",
				render: function(t, e, a) {
					return a.plan.toUpperCase()
				}
			}, {
				data: "beneficiary"
			}, {
				data: "created"
			}]
		})
	}, {
		"../../datatables": 87
	}],
	30: [function(t, e, a) {
		isPage("(admin|hmo)/subscriptions(.*)") && (t("./dt"), t("./actions"), t("./vue-add-subscription"))
	}, {
		"./actions": 28,
		"./dt": 29,
		"./vue-add-subscription": 31
	}],
	31: [function(t, e, a) {
		e.exports = new Vue({
			el: "#add-site",
			data: {
				site_id: null,
				user_id: null,
				domain: "",
				isolated: 0,
				theme: "",
				allowed_camp_themes: ADFLEX.themes.filter(function(t) {
					return "adult" !== t
				}),
				stat_url: "",
				stat_login: "",
				stat_password: "",
				button_active: !1,
				is_complete: !1
			},
			methods: {
				addSite: function() {
					var e = this;
					this.button_active = !0, $.post("/api_v1/admin/site/add", this.$data, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1, e.is_complete = !0)
					}, "json")
				},
				closeModal: function() {
					this.site_id = null, this.user_id = null, this.domain = "", this.theme = "", this.allowed_camp_themes = ADFLEX.themes.filter(function(t) {
						return "adult" !== t
					}), this.stat_url = "", this.stat_login = "", this.stat_password = "", this.button_active = !1, this.is_complete = !1, this.refreshSelectpickers(), $(document).trigger("adflex.dt.reload")
				},
				refreshSelectpickers: function() {
					this.$nextTick(function() {
						$(this.$el).find(".selectpicker").selectpicker("refresh")
					})
				}
			},
			mounted: function() {
				this.refreshSelectpickers()
			}
		})
	}, {}],
	32: [function(t, e, a) {
		e.exports = new Vue({
			el: "#edit-site",
			data: {
				site_id: null,
				isolated: null,
				domain: "",
				theme: "",
				allowed_camp_themes: ADFLEX.themes.filter(function(t) {
					return "adult" !== t
				}),
				stat_url: "",
				stat_login: "",
				stat_password: "",
				button_active: !1
			},
			methods: {
				update: function() {
					var e = this;
					this.button_active = !0, $.post("/api_v1/admin/site/update", this.$data, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1
					}, "json")
				},
				closeModal: function() {
					this.site_id = null, this.isolated = null, this.domain = "", this.theme = "", this.allowed_camp_themes = ADFLEX.themes.filter(function(t) {
						return "adult" !== t
					}), this.button_active = !1, this.stat_url = "", this.stat_login = "", this.stat_password = "", $(document).trigger("adflex.dt.reload")
				},
				init: function(t) {
					var e = this;
					$.getJSON("/api_v1/admin/site/get", {
						site_id: t
					}, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : (e.site_id = t.data.site_id, e.isolated = t.data.isolated, e.domain = t.data.domain, e.theme = t.data.theme, e.allowed_camp_themes = t.data.allowed_camp_themes.split(","), e.stat_url = t.data.stat_url, e.stat_login = t.data.stat_login, e.stat_password = t.data.stat_password, e.$nextTick(function() {
							$(this.$el).find(".selectpicker").selectpicker("refresh")
						}), $(e.$el).modal())
					})
				}
			},
			mounted: function() {
				$(function() {
					$(this.$el).find(".selectpicker").selectpicker("refresh")
				})
			}
		})
	}, {}],
	33: [function(t, e, a) {
		e.exports = new Vue({
			el: "#moderate-site",
			data: {
				site_id: null,
				domain: "",
				theme: "",
				allowed_camp_themes: "",
				stat_url: "",
				stat_login: "",
				stat_password: "",
				reject_message: "",
				rejectMessageError: !1,
				button_reject_active: !1,
				button_success_active: !1
			},
			methods: {
				reject: function() {
					var e = this;
					if(this.reject_message.length < 3) this.rejectMessageError = !0;
					else {
						var t = {
							site_id: this.site_id,
							status: -2,
							theme: this.theme,
							allowed_camp_themes: this.allowed_camp_themes,
							status_message: this.reject_message
						};
						this.button_reject_active = !0, $.post("/api_v1/admin/site/moderate", t, function(t) {
							t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), e.button_reject_active = !1
						}, "json")
					}
				},
				accept: function() {
					var e = this,
						t = {
							site_id: this.site_id,
							status: 1,
							theme: this.theme,
							allowed_camp_themes: this.allowed_camp_themes,
							status_message: ""
						};
					this.button_success_active = !0, $.post("/api_v1/admin/site/moderate", t, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), e.button_success_active = !1
					}, "json")
				},
				closeModal: function() {
					this.site_id = null, this.domain = "", this.theme = "", this.allowed_camp_themes = "", this.button_reject_active = !1, this.button_success_active = !1, this.stat_url = "", this.stat_login = "", this.stat_password = "", this.reject_message = "", this.rejectMessageError = !1, $(document).trigger("adflex.dt.reload")
				},
				init: function(t) {
					var e = this,
						a = {
							csrf: ADFLEX.csrf,
							site_id: t
						};
					$.getJSON("/api_v1/admin/site/get", a, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : (e.site_id = t.data.site_id, e.domain = t.data.domain, e.theme = t.data.theme, e.allowed_camp_themes = t.data.allowed_camp_themes.split(","), e.stat_url = t.data.stat_url, e.stat_login = t.data.stat_login, e.stat_password = t.data.stat_password, e.$nextTick(function() {
							$(".selectpicker").selectpicker("refresh")
						}), $(e.$el).modal())
					})
				}
			}
		})
	}, {}],
	34: [function(t, e, a) {
		$(function() {
			if($("#tab-buttons>a").on("click", function() {
					$("#tab-buttons>a").removeClass("btn-danger").addClass("btn-default"), $(this).removeClass("btn-default").addClass("btn-danger"), $("#tab-contents>div").addClass("hidden");
					var t = $(this).attr("href");
					$("#tab-contents").find(t).removeClass("hidden")
				}), window.location.hash.match(/#tab-\d+/gi)) {
				var t = window.location.hash;
				$("#tab-buttons").find('[href="' + t + '"]').trigger("click")
			}
		})
	}, {}],
	49: [function(t, e, a) {
		function s(t, e) {
			var a = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : "";
			$.post("/api_v1/admin/user/" + e, {
				id: t,
				message: a
			}, function(t) {
				t.error ? ADFLEX.helpers.notifyError(t.message) : (ADFLEX.helpers.notifySuccess(t.message), $(document).trigger("adflex.dt.reload"))
			}, "json")
		}
		$(document).on("click", ".item-action", function() {
			var t = $(this).attr("data-id"),
				e = $(this).attr("data-action");
			if("ban" === e) {
				var a = prompt("Specify the reason for the ban.", "");
				if(!a) return void ADFLEX.helpers.notifyError("Specify the reason for the ban!");
				s(t, e, a)
			} else "unban" === e ? s(t, e) : ""
		})
	}, {}],
	50: [function(t, e, a) {
		if(isPage("admin/users(.*)")){
			t("../../datatables")({
				url: "/api_v1/user/fetch",
				order: [
					[0, "desc"]
				],
				columns: [{
					data: "id"
				}, {
					data: null,
					render: function(t, e, a) {
						return a.role == "beneficiary" ? a.first_name + ' ' + a.last_name : a.business_name
					}
				}, {
					data: "email"
				}, {
					data: "role",
					render: function(t, e, a) {
						return "<span class='label label-default'>" + a.role.toUpperCase() + "</span>"
					}
				}, {
					data: "hmo"
				}, {
					data: "plan",
					render: function(t, e, a) {
						return a.plan.toUpperCase()
					}
				}, {
					data: "status",
					render: function(t, e, a) {
						return tmpl("status", a)
					}
				}, {
					data: "created"
				}]
			})
		}
		if(isPage("admin/managers(.*)")){
			t("../../datatables")({
				url: "/api_v1/user/fetch/hmo",
				order: [
					[0, "desc"]
				],
				columns: [{
					data: "id"
				}, {
					data: null,
					render: function(t, e, a) {
						return a.business_name
					}
				}, {
					data: "email"
				}, {
					data: null,
					render: function(t, e, a) {
						return "<a href='/admin/hmo_report/" + a.id + "' target='_blank' class='btn btn-sm btn-primary'><i class='fa fa-th-list'></i> Report</a>"
					}
				}, {
					data: "status",
					render: function(t, e, a) {
						return tmpl("status", a)
					}
				}, {
					data: "created"
				}]
			})
		}
		if(isPage("hmo/users(.*)")){
			t("../../datatables")({
				url: "/api_v1/user/fetch",
				order: [
					[0, "desc"]
				],
				columns: [{
					data: "id"
				}, {
					data: null,
					render: function(t, e, a) {
						return a.role == "beneficiary" ? a.first_name + ' ' + a.last_name : a.business_name
					}
				}, {
					data: "email"
				}, {
					data: "role",
					render: function(t, e, a) {
						return "<span class='label label-default'>" + a.role.toUpperCase() + "</span>"
					}
				}, {
					data: "plan",
					render: function(t, e, a) {
						return a.plan.toUpperCase()
					}
				}, {
					data: "status",
					render: function(t, e, a) {
						return tmpl("status", a)
					}
				}, {
					data: "created"
				}]
			})
		}
		if(isPage("hmo/providers(.*)")){
			t("../../datatables")({
				url: "/api_v1/user/fetch/sp",
				order: [
					[0, "desc"]
				],
				columns: [{
					data: "id"
				}, {
					data: null,
					render: function(t, e, a) {
						return a.business_name
					}
				}, {
					data: "email"
				}, {
					data: null,
					render: function(t, e, a) {
						return "<a href='/hmo/sp_report/" + a.id + "' target='_blank' class='btn btn-sm btn-primary'><i class='fa fa-th-list'></i> Report</a>"
					}
				}, {
					data: "status",
					render: function(t, e, a) {
						return tmpl("status", a)
					}
				}, {
					data: "created"
				}]
			})
		}
	}, {
		"../../datatables": 87
	}],
	51: [function(t, e, a) {
		isPage("(admin|hmo)/(users|managers|providers)(.*)") && (t("./dt"), t("./actions"), t("./vue-add-user"))
	}, {
		"./actions": 49,
		"./dt": 50,
		"./vue-add-user": 52
	}],
	52: [function(t, e, a) {
		e.exports = new Vue({
			el: "#add-user",
			data: {
				first_name: "",
				last_name: "",
				business_name: "",
				email: "",
				password: "",
				role: "beneficiary",
				plan_id: "",
				status_message: "",
				activation_link: "",
				error: !1
			},
			methods: {
				randomPassword: function() {
					for(var t = "abcdefghijklmnopqrstuvwxyz!@#$%*()-+<>ABCDEFGHIJKLMNOP1234567890", e = "", a = 0; a < 10; a++) {
						var i = Math.floor(Math.random() * t.length);
						e += t.charAt(i)
					}
					this.password = e
				},
				addUser: function() {
					var e = this;
					e.randomPassword(), e.error = !1, $.post("/api_v1/user/create", e.$data, function(t) {
						t.error ? (e.error = !0, e.status_message = t.message) : (e.status_message = t.message, e.activation_link = t.data.activation_link)
					}, "json")
				}
			}
		})
	}, {}],
	81: [function(t, e, a) {
		new Vue({
			el: "#app-forgot-password",
			data: {
				email: "",
				error_message: "",
				active_button: !1,
				step_two: !1
			},
			methods: {
				forgot: function() {
					var e = this,
						t = {
							email: e.email
						};
					e.active_button = !0, $.post("/auth/api_forgot_password", t, function(t) {
						t.error ? (e.error_message = t.message, e.active_button = !1) : e.step_two = !0
					}, "json")
				}
			}
		})
	}, {}],
	82: [function(t, e, a) {
		new Vue({
			el: "#app-login",
			data: {
				email: "",
				password: "",
				error_message: "",
				active_button: !1,
				show_autologin_box: !1
			},
			methods: {
				logIn: function() {
					var e = this,
						t = {
							email: e.email,
							password: e.password
						};
					e.active_button = !0, $.post("/auth/api_login", t, function(t) {
						t.error ? (e.error_message = t.message, e.active_button = !1) : location.reload()
					}, "json")
				}
			}
		})
	}, {}],
	83: [function(t, e, a) {
		new Vue({
			el: "#app-register",
			data: {
				username: "",
				email: "",
				password: "",
				error_message: "",
				active_button: !1
			},
			methods: {
				register: function() {
					var e = this,
						t = {
							username: e.username,
							email: e.email,
							password: e.password
						};
					e.active_button = !0, $.post("/auth/api_register", t, function(t) {
						e.active_button = !1, t.error ? e.error_message = t.message : window.location.reload()
					}, "json")
				}
			}
		})
	}, {}],
	84: [function(t, e, a) {
		new Vue({
			el: "#app-reset-password",
			data: {
				new_password: "",
				error_message: "",
				active_button: !1,
				step_two: !1
			},
			methods: {
				resetPassword: function() {
					var e = this,
						t = {
							new_password: e.new_password,
							reset_pass_token: location.href.split("/")[5]
						};
					e.active_button = !0, $.post("/auth/api_reset_password", t, function(t) {
						t.error ? (e.error_message = t.message, e.active_button = !1) : (e.error_message = "", e.step_two = !0)
					}, "json")
				}
			}
		})
	}, {}],
	85: [function(t, e, a) {
		e.exports = {
			csrf: $("[name='csrf']").attr("content"),
			url: {},
			helpers: {
				notifyError: function(t) {
					this.notify(t, "fa fa-exclamation-circle", "danger", "Error!")
				},
				notifySuccess: function(t) {
					this.notify(t, "fa fa-check-circle", "success", "Success!")
				},
				notifyInfo: function(t) {
					this.notify(t, "fa fa-info-circle", "warning", "Info!")
				},
				notify: function(t, e, a, i) {
					t = t || "", e = e || "fa fa-info-circle", a = a || "warning", i = i || "", $.notify({
						icon: e,
						title: "<strong>" + i + "</strong> <br>",
						message: t
					}, {
						z_index: 10310,
						type: a,
						placement: {
							from: "bottom"
						},
						animate: {
							enter: "animated fadeInUp",
							exit: "animated fadeOutDown"
						}
					})
				},
				parse_get: function(t, e) {
					e || (e = window.location.href), t = t.replace(/[\[\]]/g, "\\$&");
					var a = new RegExp("[?&]" + t + "(=([^&#]*)|&|#|$)").exec(e);
					return a ? a[2] ? decodeURIComponent(a[2].replace(/\+/g, " ")) : "" : null
				},
				escapeHtml: function(t) {
					var e = {
						"&": "&amp;",
						"<": "&lt;",
						">": "&gt;",
						'"': "&quot;",
						"'": "&#039;"
					};
					return t.replace(/[&<>"']/g, function(t) {
						return e[t]
					})
				}
			}
		}
	}, {}],
	87: [function(t, e, a) {
		e.exports = function(t) {
			var i = $.extend(!0, {
					url: "",
					method: "POST",
					columns: [],
					order: [
						[1, "desc"]
					],
					perpage: 10,
					id: "_datatable",
					multiaction: !1,
					rowCallback: !1,
					buttons: !1,
					group: !1,
					reorder: [],
					hideLoadThead: !1
				}, t),
				e = !1;
			i.hideLoadThead && $("#" + i.id).find("thead").hide();
			var a = $("#" + i.id).DataTable({
				processing: !0,
				serverSide: !0,
				order: i.order,
				ajax: {
					url: i.url,
					type: i.method,
					data: $.extend(i.data, {
						group: i.group
					})
				},
				pageLength: i.perpage,
				keepConditions: !0,
				columns: i.columns,
				colReorder: !0,
				fnDrawCallback: function(t) {
					!1 === e && i.reorder.length && a.colReorder.order(i.reorder), $("#" + i.id).find("thead").show(), 0 < t.aoData.length && $("#" + i.id + "-wrapper").removeClass("hidden"), e || "function" != typeof i.multiaction || ($("#" + i.id + "_length").prepend('<label style="margin-right: 20px;">\n                                <select id="' + i.id + '-multi-actions" class="form-control input-sm" style="width: auto;">\n                                    <option selected value="---">Actions</option>\n                                    <option value="stop">Stop</option>\n                                    <option value="play">Play</option>\n                                    <option value="delete">Delete</option>\n                                </select>\n                            </label>'), $("#" + i.id + "-multi-actions").val("---"), $("#" + i.id + "-check-all").prop("checked", !1), 2 < window.location.hash.length && setTimeout(function() {
						a.ajax.reload()
					}, 100)), !e && i.buttons && $("#" + i.id + "_filter").append(i.buttons), e = !0
				},
				rowCallback: function(t, e, a) {
					"function" == typeof i.rowCallback && i.rowCallback(t, e, a)
				}
			}).on("page.dt order.dt length.dt", function() {
				$("#" + i.id + "-multi-actions").val("---"), $("#" + i.id + "-check-all").prop("checked", !1)
			}).on("draw", function() {
				$(document).trigger("adflex.dt.loaded")
			});
			if($(document).on("change", "#" + i.id + "-check-all", function() {
					var t = $(this).prop("checked");
					$("#" + i.id).find("._datatable-item").prop("checked", t)
				}), $(document).on("change", "#" + i.id + "-multi-actions", function() {
					var t = $(this).val(),
						e = [];
					$("._datatable-item:checked").each(function() {
						e.push($(this).val())
					}), 0 < e.length && "function" == typeof i.multiaction && confirm("Confirm action?") && i.multiaction(t, e), $(this).val("---")
				}), $(document).on("adflex.dt.reload", function() {
					a.ajax.reload()
				}), parse_get("searchquery")) {
				var n = parse_get("searchquery");
				n && a.search(n).draw()
			}
		}
	}, {}],
	88: [function(t, e, a) {
		$(function() {
			var t = localStorage.getItem("start_date") ? moment(localStorage.getItem("start_date")) : moment(),
				e = localStorage.getItem("end_date") ? moment(localStorage.getItem("end_date")) : moment();

			function a(t, e, a) {
				localStorage.setItem("start_date", t.format("YYYY-MM-DD")), localStorage.setItem("end_date", e.format("YYYY-MM-DD")), $("body").data("start_date", t.format("YYYY-MM-DD")), $("body").data("end_date", e.format("YYYY-MM-DD")), isPage("(.*)/statistics/(.*)") && $(document).trigger("adflex.dt.reload"), $("#reportrange span").html('<i class="fa fa-fw fa-calendar"></i> ' + t.format("YYYY/MM/DD") + " &mdash; " + e.format("YYYY/MM/DD"))
			}
			$("#reportrange").daterangepicker({
				startDate: t,
				endDate: e,
				ranges: {
					Today: [moment(), moment()],
					Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
					"Last 7 Days": [moment().subtract(6, "days"), moment()],
					"Last 30 Days": [moment().subtract(29, "days"), moment()]
				}
			}, a), a(t, e)
		})
	}, {}],
	89: [function(t, e, a) {
		t("domready")(function() {
			window.ADFLEX = t("./cfg"), t("./t-tabs"), t("./global"), t("./translations"), t("./vue_filters"), t("./vue_components/timezone"), t("./vue_components"), t("./daterangepicker"), t("./auth/login"), t("./auth/register"), t("./auth/forgot"), t("./auth/reset-password"), t("./admin/users/index"), t("./admin/subscriptions/index"), t("./admin/settings/index"), t("./admin/payouts/index"), t("./admin/payments/index"), t("./admin/dashboard/index")
		})
	}, {
		"./admin/dashboard/index": 11,
		"./admin/payments/index": 17,
		"./admin/payouts/index": 20,
		"./admin/settings/index": 26,
		"./admin/subscriptions/index": 30,
		"./admin/users/index": 51,
		"./auth/forgot": 81,
		"./auth/login": 82,
		"./auth/register": 83,
		"./auth/reset-password": 84,
		"./cfg": 85,
		"./daterangepicker": 88,
		"./global": 90,
		"./t-tabs": 115,
		"./translations": 116,
		"./vue_components": 117,
		"./vue_components/timezone": 122,
		"./vue_filters": 125,
		domready: 163
	}],
	90: [function(t, e, a) {
		var i = t("../../../env");
		window.array_fill = function(t, e) {
			for(var a = [], i = 0; i < t; i++) a.push(e);
			return a
		}, window.isPage = function(t) {
			var e = t.replace(/^\/|\/$/g, "").replace(/\//g, "\\/"),
				a = location.pathname.substring(1).replace(/^\/|\/$/g, "").match(new RegExp("^" + e + "$", "gi"));
			return a && "dev" == i && console.log(t), a
		}, window.getUrlSegment = function(t) {
			var e = window.location.href.split("/")[t].replace(/\#.*/, "");
			return e && "dev" == i && console.log(e), e
		}, window.notify = function() {
			var t = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : "",
				e = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "fa fa-info-circle",
				a = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : "warning",
				i = 3 < arguments.length && void 0 !== arguments[3] ? arguments[3] : "";
			$.notify({
				icon: e,
				title: "<strong>" + i + "</strong> <br>",
				message: t
			}, {
				z_index: 10310,
				type: a,
				placement: {
					from: "bottom"
				},
				animate: {
					enter: "animated fadeInUp",
					exit: "animated fadeOutDown"
				}
			})
		}, window.notifyError = function(t) {
			notify(t, "fa fa-exclamation-circle", "danger", "Error!")
		}, window.notifySuccess = function(t) {
			notify(t, "fa fa-check-circle", "success", "Success!")
		}, window.notifyInfo = function(t) {
			notify(t, "fa fa-info-circle", "warning", "Info!")
		}, window.toLocalDate = function(t) {
			var e = moment.utc(t);
			return moment.tz(e, window.timezone).format("YYYY-MM-DD HH:mm:ss")
		}, window.toLocalDateFromNow = function(t) {
			var e = moment.utc(t);
			return moment.tz(e, window.timezone).fromNow()
		}, window.debounce = function(i, n, s) {
			var r;
			return function() {
				var t = this,
					e = arguments,
					a = s && !r;
				clearTimeout(r), r = setTimeout(function() {
					r = null, s || i.apply(t, e)
				}, n), a && i.apply(t, e)
			}
		}, window.throttle = function(e, a) {
			var i, n, s = !1;
			return function t() {
				if(s) return i = arguments, void(n = this);
				e.apply(this, arguments), s = !0, setTimeout(function() {
					s = !1, i && (t.apply(n, i), i = n = null)
				}, a)
			}
		}, window.parse_get = function(t, e) {
			e || (e = window.location.href), t = t.replace(/[\[\]]/g, "\\$&");
			var a = new RegExp("[?&]" + t + "(=([^&#]*)|&|#|$)").exec(e);
			return a ? a[2] ? decodeURIComponent(a[2].replace(/\+/g, " ")) : "" : null
		}, $(document).on("click", ".close-notificator", function() {
			$(this).parent().fadeOut(800)
		}), setTimeout(function() {
			$(".notificator").not(".notificator-static").fadeOut(2e3)
		}, 3e3), $(document).on("click", ".btn-clipboard", function() {
			var t = $(this).parents().eq(2).find("input").val();
			copy(t), notifySuccess("Copied!")
		}), $("body").tooltip({
			html: !0,
			selector: '[data-toggle="tooltip"]'
		}), Chart.plugins.register({
			afterDraw: function(t) {
				if(0 === t.data.labels.length) {
					var e = t.chart.ctx,
						a = t.chart.width,
						i = t.chart.height;
					t.clear(), e.save(), e.textAlign = "center", e.textBaseline = "middle", e.font = "24px normal 'Helvetica Nueue'", e.fillText("No data to display", a / 2, i / 2), e.restore()
				}
			}
		}), $(document).on("click", "#dt-reload-btn", function() {
			$(this).find(".fa").addClass("fa-spin"), $(document).trigger("adflex.dt.reload")
		}), $(document).on("adflex.dt.loaded", function() {
			$("#dt-reload-btn > .fa").removeClass("fa-spin")
		}), $.ajaxSetup({
			data: {
				csrf: $("[name='csrf']").attr("content")
			}
		}), $(function() {
			var e = "";

			function a(t) {
				if((!t || t.hasClass("fix-dropdown")) && t instanceof jQuery) {
					var e = $(t).siblings(".dropdown-menu");
					e.css({
						top: t.offset().top + t.outerHeight(),
						left: t.offset().left - (e.outerWidth() - t.outerWidth()),
						position: "fixed",
						"max-width": "200px"
					})
				}
			}
			$(document).on("show.bs.dropdown", function(t) {
				a(e = $(t.relatedTarget))
			}), $(window).on("resize scroll", _.throttle(function() {
				a(e)
			}, 100)), $(".table-responsive").on("scroll", _.throttle(function() {
				a(e)
			}, 100))
		}), jQuery.fn.sizeChanged = function(t) {
			var e = this,
				a = e.width(),
				i = e.height();
			return setInterval(function() {
				a === e.width() && i === e.height() || "function" == typeof t && (t({
					width: a,
					height: i
				}, {
					width: e.width(),
					height: e.height()
				}), a = e.width(), i = e.height())
			}, 1e3), e
		}
	}, {
		"../../../env": 162
	}],
	115: [function(t, e, a) {
		$(function() {
			var t = function() {
				/^#t-tab-[0-9]+$/.test(location.hash) && ($("#t-btn-container > a").removeClass("btn-danger").addClass("btn-default"), $('#t-btn-container > a[href="' + location.hash + '"]').removeClass("btn-default").addClass("btn-danger"), $(".t-tabs-container > div").addClass("hidden"), $(location.hash).removeClass("hidden"))
			};
			t(), $(window).on("hashchange", t)
		})
	}, {}],
	116: [function(t, e, a) {
		window.__ = function(t) {
			return "en" == window.lang ? window.translations[t.trim()] ? window.translations[t.trim()] : "_" + t.trim() : t
		}
	}, {}],
	117: [function(t, e, a) {
		t("./vue_components/input-amount"), t("./vue_components/input-number"), t("./vue_components/input-hide-show"), t("./vue_components/timezone"), t("./vue_components/user-search"), t("./vue_components/vue-button"), Vue.directive("longclick", {
			bind: function(e, a, t) {
				if("function" != typeof a.value) {
					var i = t.context.name,
						n = "[longclick:] provided expression '" + a.expression + "' is not a function, but has to be";
					i && (n += "Found in component '" + i + "' "), console.warn(n)
				}
				var s = null,
					r = null;

				function o(t) {
					"click" === t.type && 0 !== t.button || null === s && (s = setTimeout(function() {
						r = setInterval(function() {
							c()
						}, 50), c()
					}, 400))
				}

				function d() {
					null !== s && (clearTimeout(s), s = null), r && (clearInterval(r), r = null)
				}

				function c(t) {
					a.value(t)
				}["mousedown", "touchstart"].forEach(function(t) {
					e.addEventListener(t, o)
				}), ["click", "mouseout", "touchend", "touchcancel"].forEach(function(t) {
					e.addEventListener(t, d)
				})
			}
		})
	}, {
		"./vue_components/input-amount": 118,
		"./vue_components/input-hide-show": 120,
		"./vue_components/input-number": 121,
		"./vue_components/timezone": 122,
		"./vue_components/user-search": 123,
		"./vue_components/vue-button": 124
	}],
	118: [function(t, e, a) {
		Vue.component("input-amount", {
			data: function() {
				return {
					amount_: this.value
				}
			},
			props: ["min", "max", "value"],
			methods: {
				handleInput: function(t) {
					var e = parseFloat(t).toFixed(2),
						a = parseFloat(this.max),
						i = parseFloat(this.min);
					isNaN(e) ? this.amount_ = parseFloat(this.min).toFixed(2) : this.amount_ = a < e ? parseFloat(this.max).toFixed(2) : e < i ? parseFloat(this.min).toFixed(2) : e, this.$emit("input", this.amount_)
				}
			},
			watch: {
				value: function(t) {
					this.amount_ = parseFloat(t).toFixed(2)
				}
			},
			template: '<input v-model="amount_" @change="handleInput($event.target.value)" type="text" class="form-control">'
		})
	}, {}],
	119: [function(t, e, a) {
		Vue.component("input-colorpicker", {
			props: ["value"],
			data: function() {
				return {
					input_id: null,
					color: null,
					colorpicker: null
				}
			},
			methods: {
				setColor: function(t) {
					this.colorpicker.colorpicker("setValue", t)
				}
			},
			mounted: function() {
				this.input_id = "colorpicker" + _.random(1, 1e10), this.color = this.value, this.$nextTick(function() {
					var e = this;
					this.colorpicker = $("#" + this.input_id).colorpicker({
						color: this.color,
						format: "hex"
					}).on("changeColor", function(t) {
						e.color = t.color.toHex(), e.$emit("input", e.color)
					})
				})
			},
			watch: {
				value: function(t) {
					this.color = t, this.setColor(t)
				}
			},
			template: '\n    <div :id="input_id" class="input-group colorpicker-component">\n        <input type="text" class="form-control"/>\n        <span class="input-group-addon"><i></i></span>\n    </div>\n    '
		})
	}, {}],
	120: [function(t, e, a) {
		Vue.component("input-hide-show", {
			data: function() {
				return {
					show: !1,
					model: this.value,
					input_type: "text"
				}
			},
			props: ["value", "placeholder"],
			methods: {
				handleInput: function(t) {
					this.$emit("input", this.model)
				},
				changeInputType: function() {
					this.show = !this.show
				}
			},
			watch: {
				value: function(t) {
					this.model = t
				}
			},
			template: '<div class="input-group">\n                    <input v-if="show"\n                           v-model="model"\n                           @input="handleInput($event.target.value)"\n                           v-bind:placeholder="placeholder"\n                           class="form-control"\n                           v-bind:type="input_type"\n                           autocomplete="off">\n    \n                    <input v-else\n                           class="form-control"\n                           type="text"\n                           autocomplete="off"\n                           disabled\n                           placeholder="********************************">\n    \n                    <div class="input-group-btn">\n                        <button @click="changeInputType" class="btn btn-default btn-flat">\n                            <i v-if="input_type == \'password\'" class="fa fa-fw fa-eye"></i>\n                            <i v-else class="fa fa-fw fa-eye-slash"></i>\n                        </button>\n                    </div>\n                </div>'
		})
	}, {}],
	121: [function(t, e, a) {
		Vue.component("input-number", {
			data: function() {
				return {
					number_: this.value
				}
			},
			props: ["min", "max", "value"],
			methods: {
				handleInput: function(t) {
					var e = parseInt(t),
						a = parseInt(this.max),
						i = parseInt(this.min);
					isNaN(e) ? this.number_ = parseInt(this.min) : this.number_ = a < e ? parseInt(this.max) : e < i ? parseInt(this.min) : e, this.$emit("input", this.number_)
				}
			},
			watch: {
				value: function(t) {
					this.number_ = parseInt(t)
				}
			},
			template: '<input v-model="number_" @change="handleInput($event.target.value)" type="text" class="form-control">'
		})
	}, {}],
	122: [function(t, e, a) {
		Vue.component("select-timezone", {
			data: function() {
				return {
					timezone_: this.value
				}
			},
			props: ["value"],
			methods: {},
			watch: {
				value: function(t) {
					this.timezone_ = t
				}
			},
			template: '<select v-model="timezone_" @change="$emit(\'input\', $event.target.value)" class="form-control btn-flat selectpicker" data-size="12" data-style="btn-default btn-flat">\n                    <option value="Pacific/Midway">(GMT-11:00) Midway Island, Samoa</option>\n                    <option value="America/Adak">(GMT-10:00) Hawaii-Aleutian</option>\n                    <option value="Etc/GMT+10">(GMT-10:00) Hawaii</option>\n                    <option value="Pacific/Marquesas">(GMT-09:30) Marquesas Islands</option>\n                    <option value="Pacific/Gambier">(GMT-09:00) Gambier Islands</option>\n                    <option value="America/Anchorage">(GMT-09:00) Alaska</option>\n                    <option value="America/Ensenada">(GMT-08:00) Tijuana, Baja California</option>\n                    <option value="Etc/GMT+8">(GMT-08:00) Pitcairn Islands</option>\n                    <option value="America/Los_Angeles">(GMT-08:00) Pacific Time (US & Canada)</option>\n                    <option value="America/Denver">(GMT-07:00) Mountain Time (US & Canada)</option>\n                    <option value="America/Chihuahua">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>\n                    <option value="America/Dawson_Creek">(GMT-07:00) Arizona</option>\n                    <option value="America/Belize">(GMT-06:00) Saskatchewan, Central America</option>\n                    <option value="America/Cancun">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>\n                    <option value="Chile/EasterIsland">(GMT-06:00) Easter Island</option>\n                    <option value="America/Chicago">(GMT-06:00) Central Time (US & Canada)</option>\n                    <option value="America/New_York">(GMT-05:00) Eastern Time (US & Canada)</option>\n                    <option value="America/Havana">(GMT-05:00) Cuba</option>\n                    <option value="America/Bogota">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>\n                    <option value="America/Caracas">(GMT-04:30) Caracas</option>\n                    <option value="America/Santiago">(GMT-04:00) Santiago</option>\n                    <option value="America/La_Paz">(GMT-04:00) La Paz</option>\n                    <option value="Atlantic/Stanley">(GMT-04:00) Faukland Islands</option>\n                    <option value="America/Campo_Grande">(GMT-04:00) Brazil</option>\n                    <option value="America/Goose_Bay">(GMT-04:00) Atlantic Time (Goose Bay)</option>\n                    <option value="America/Glace_Bay">(GMT-04:00) Atlantic Time (Canada)</option>\n                    <option value="America/St_Johns">(GMT-03:30) Newfoundland</option>\n                    <option value="America/Araguaina">(GMT-03:00) UTC-3</option>\n                    <option value="America/Montevideo">(GMT-03:00) Montevideo</option>\n                    <option value="America/Miquelon">(GMT-03:00) Miquelon, St. Pierre</option>\n                    <option value="America/Godthab">(GMT-03:00) Greenland</option>\n                    <option value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires</option>\n                    <option value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>\n                    <option value="America/Noronha">(GMT-02:00) Mid-Atlantic</option>\n                    <option value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>\n                    <option value="Atlantic/Azores">(GMT-01:00) Azores</option>\n                    <option value="Europe/London">(GMT) Greenwich Mean Time</option>\n                    <option value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>\n                    <option value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>\n                    <option value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>\n                    <option value="Africa/Algiers">(GMT+01:00) West Central Africa</option>\n                    <option value="Africa/Windhoek">(GMT+01:00) Windhoek</option>\n                    <option value="Asia/Beirut">(GMT+02:00) Beirut</option>\n                    <option value="Africa/Cairo">(GMT+02:00) Cairo</option>\n                    <option value="Asia/Gaza">(GMT+02:00) Gaza</option>\n                    <option value="Africa/Blantyre">(GMT+02:00) Harare, Pretoria</option>\n                    <option value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>\n                    <option value="Europe/Minsk">(GMT+02:00) Minsk</option>\n                    <option value="Asia/Damascus">(GMT+02:00) Syria</option>\n                    <option value="Europe/Moscow">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>\n                    <option value="Africa/Addis_Ababa">(GMT+03:00) Nairobi</option>\n                    <option value="Asia/Tehran">(GMT+03:30) Tehran</option>\n                    <option value="Asia/Dubai">(GMT+04:00) Abu Dhabi, Muscat</option>\n                    <option value="Asia/Yerevan">(GMT+04:00) Yerevan</option>\n                    <option value="Asia/Kabul">(GMT+04:30) Kabul</option>\n                    <option value="Asia/Yekaterinburg">(GMT+05:00) Ekaterinburg</option>\n                    <option value="Asia/Tashkent">(GMT+05:00) Tashkent</option>\n                    <option value="Asia/Kolkata">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>\n                    <option value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>\n                    <option value="Asia/Novosibirsk">(GMT+06:00) Novosibirsk</option>\n                    <option value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>\n                    <option value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>\n                    <option value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>\n                    <option value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>\n                    <option value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar</option>\n                    <option value="Australia/Perth">(GMT+08:00) Perth</option>\n                    <option value="Australia/Eucla">(GMT+08:45) Eucla</option>\n                    <option value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>\n                    <option value="Asia/Seoul">(GMT+09:00) Seoul</option>\n                    <option value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>\n                    <option value="Australia/Adelaide">(GMT+09:30) Adelaide</option>\n                    <option value="Australia/Darwin">(GMT+09:30) Darwin</option>\n                    <option value="Australia/Brisbane">(GMT+10:00) Brisbane</option>\n                    <option value="Australia/Hobart">(GMT+10:00) Hobart</option>\n                    <option value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>\n                    <option value="Australia/Lord_Howe">(GMT+10:30) Lord Howe Island</option>\n                    <option value="Etc/GMT-11">(GMT+11:00) Solomon Is., New Caledonia</option>\n                    <option value="Asia/Magadan">(GMT+11:00) Magadan</option>\n                    <option value="Pacific/Norfolk">(GMT+11:30) Norfolk Island</option>\n                    <option value="Asia/Anadyr">(GMT+12:00) Anadyr, Kamchatka</option>\n                    <option value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>\n                    <option value="Etc/GMT-12">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>\n                    <option value="Pacific/Chatham">(GMT+12:45) Chatham Islands</option>\n                    <option value="Pacific/Tongatapu">(GMT+13:00) Nuku\'alofa</option>\n                    <option value="Pacific/Kiritimati">(GMT+14:00) Kiritimati</option>\n                </select>'
		})
	}, {}],
	123: [function(t, e, a) {
		Vue.component("user-search", {
			data: function() {
				return {
					query: this.value,
					select_item: this.value,
					items: [],
					loading: !1,
					not_results: !1
				}
			},
			props: ["value", "placeholder", "api_url"],
			methods: {
				search: debounce(function() {
					var e = this;
					if(this.$emit("input", this.query), 0 != this.query.length) {
						this.loading = !0;
						var t = this.api_url ? this.api_url : "/api_v1/admin/user/search";
						$.getJSON(t, {
							q: this.query
						}, function(t) {
							0 == t.data.length ? e.not_results = !0 : e.not_results = !1, e.items = t.data, e.loading = !1
						})
					}
				}, 300),
				select: function(t) {
					this.query = t, this.select_item = t, this.items = [], this.loading = !1, this.$emit("input", t)
				},
				reset: function() {
					this.items = [], this.query = null, this.select_item = null, this.loading = !1, this.$emit("input", null)
				},
				closeTips: function() {
					var t = this;
					setTimeout(function() {
						t.items = [], t.not_results = !1
					}, 800)
				}
			},
			computed: {
				addon: function() {
					return this.loading ? "loading" : this.query || this.select_item ? "close" : "default"
				}
			},
			watch: {
				value: function(t) {
					this.query = t, this.select_item = t
				}
			},
			template: '<div class="user-search">\n                <div class="input-group">\n                <input v-model="query" @input="search" @blur="closeTips" type="text" v-bind:placeholder="placeholder" class="form-control">\n\n                    <span v-if="addon == \'default\'" class="input-group-addon">\n                      <i class="fa fa-fw fa-search"></i>\n                    </span>\n\n                    <span v-if="addon == \'loading\'" class="input-group-addon">\n                      <i class="fa fa-circle-o-notch fa-spin fa-fw"></i>\n                    </span>\n\n                    <span v-if="addon == \'close\'" class="input-group-btn">\n                      <button @click="reset" class="btn btn-default btn-flat">\n                        <i class="fa fa-fw fa-times"></i>\n                      </button>\n                    </span>\n                </div>\n\n                <ul v-if="items.length > 0">\n                    <li v-for="item in items" @click="select(item.id)">\n                           <b>User ID:</b> <span>{{item.id}}</span>\n                           <b>Username:</b> <span>{{item.username}}</span>\n                           <b>E-mail:</b> <span>{{item.email}}</span>\n                    </li>\n                </ul>\n\n                <ul v-else-if="not_results">\n                    <li class="not-results">\n                           Not results...\n                    </li>\n                </ul>\n\n              </div>'
		})
	}, {}],
	124: [function(t, e, a) {
		Vue.component("vue-button", {
			data: function() {
				return {
					button_active: !1,
					btn_class: this.$props.btn ? "btn-" + this.$props.btn : "btn-default",
					btn_fa: this.$props.fa ? this.$props.fa : null,
					btn_title: this.$props.title ? this.$props.title : "Button"
				}
			},
			props: ["fa", "title", "btn"],
			methods: {
				handler: function() {
					this.btn_fa && (this.button_active = !0), this.$emit("click")
				},
				end: function() {
					this.button_active = !1
				}
			},
			template: '<button @click="handler" v-bind:disabled="button_active" v-bind:class="btn_class" class="btn">\n                    <span v-if="btn_fa">\n                        <i v-if="button_active" class="fa fa-circle-o-notch fa-spin fa-fw"></i>\n                        <i v-else v-bind:class="btn_fa" class="fa fa-fw"></i>\n                    </span>\n                    {{btn_title}}\n                </button>'
		})
	}, {}],
	125: [function(t, e, a) {
		e.exports = Vue.filter("toLocalDate", function(t) {
			return window.toLocalDate(t)
		}), e.exports = Vue.filter("toLocalDateFromNow", function(t) {
			return window.toLocalDateFromNow(t)
		}), e.exports = Vue.filter("capitalize", function(t) {
			return t ? (t = t.toString()).charAt(0).toUpperCase() + t.slice(1) : ""
		})
	}, {}],
	162: [function(t, e, a) {
		e.exports = "prod"
	}, {}],
	163: [function(t, a, e) {
		! function(t, e) {
			void 0 !== a ? a.exports = e() : "function" == typeof define && "object" == _typeof(define.amd) ? define(e) : this.domready = e()
		}(0, function() {
			var t, e = [],
				a = document,
				i = a.documentElement.doScroll,
				n = "DOMContentLoaded",
				s = (i ? /^loaded|^c/ : /^loaded|^i|^c/).test(a.readyState);
			return s || a.addEventListener(n, t = function() {
					for(a.removeEventListener(n, t), s = 1; t = e.shift();) t()
				}),
				function(t) {
					s ? setTimeout(t, 0) : e.push(t)
				}
		})
	}, {}]
}, {}, [89]);