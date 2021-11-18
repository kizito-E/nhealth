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
	2: [function(t, e, a) {
		var i = t("./vue-moderate");
		$(document).on("click", ".dsa-action", function() {
			var t = {
					ad_id: $(this).attr("data-id")
				},
				e = $(this).attr("data-action"),
				a = "";
			if("play" === e) a = "/api/admin/ads/play";
			else if("stop" === e) a = "/api/admin/ads/stop";
			else if("ban" === e) {
				if(t.status_message = prompt("Specify the reason for the ban.", ""), !t.status_message) return;
				a = "/api/admin/ads/ban"
			} else if("unban" === e) a = "/api/admin/ads/unban";
			else {
				if("edit" === e) return;
				if("moderate" === e) return void i.init(t.ad_id)
			}
			$.post(a, t, function(t) {
				t.error ? ADFLEX.helpers.notifyError(t.message) : (ADFLEX.helpers.notifySuccess(t.message), $(document).trigger("adflex.dt.reload"))
			}, "json")
		}), $(document).on("click", ".ad-preview", function() {
			var t = {
				ad_id: $(this).attr("data")
			};
			$.getJSON("/api/admin/ads/get", t, function(t) {
				t.error ? ADFLEX.helpers.notifyError(t.message) : $(tmpl("dsa-preview", t.data)).modal()
			})
		})
	}, {
		"./vue-moderate": 5
	}],
	3: [function(t, e, a) {
		t("../../datatables")({
			url: "/api/admin/ads/fetch",
			data: {
				filter_user_id: window.filter_user_id
			},
			order: [
				[0, "desc"]
			],
			columns: [{
				data: "ad_id"
			}, {
				data: "user_id",
				render: function(t, e, a) {
					return tmpl("userdata", a)
				}
			}, {
				data: "camp_id",
				render: function(t, e, a) {
					return tmpl("camp", a)
				}
			}, {
				data: "payment_mode",
				render: function(t, e, a) {
					return tmpl("payment", {
						mode: a.payment_mode.toUpperCase(),
						cpc: numeral(a.cpc).format("0,0.00"),
						cpv: numeral(a.cpv).format("0,0.00")
					})
				}
			}, {
				data: "status",
				render: function(t, e, a) {
					return tmpl("status", a)
				}
			}, {
				data: "type",
				render: function(t, e, a, i) {
					return tmpl("type", a)
				}
			}, {
				data: "preview",
				sortable: !1,
				render: function(t, e, a) {
					return tmpl("preview", a)
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
	4: [function(t, e, a) {
		isPage("administrator/ads(.*)") && (t("./dt"), t("./actions"))
	}, {
		"./actions": 2,
		"./dt": 3
	}],
	5: [function(t, e, a) {
		e.exports = new Vue({
			el: "#moderate-dsa",
			data: {
				ad_id: null,
				hash_id: "",
				user_id: "",
				camp_id: "",
				camp_theme: "",
				title: "",
				description: "",
				ad_url: "",
				action_text: "",
				img_url: "",
				img_width: "",
				img_height: "",
				cpc: "",
				cpv: "",
				payment_mode: "",
				status_message: "",
				type: "",
				reject_message: "",
				rejectMessageError: !1,
				button_success_active: !1,
				button_reject_active: !1
			},
			methods: {
				reject: function() {
					var e = this;
					if(this.reject_message.length < 3) this.rejectMessageError = !0;
					else {
						var t = {
							ad_id: this.ad_id,
							status: -2,
							status_message: this.reject_message
						};
						this.button_reject_active = !0, $.post("/api/admin/ads/moderate", t, function(t) {
							t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), e.button_reject_active = !1
						}, "json")
					}
				},
				accept: function() {
					var e = this,
						t = {
							ad_id: this.ad_id,
							status: 1,
							status_message: ""
						};
					this.button_success_active = !0, $.post("/api/admin/ads/moderate", t, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), e.button_success_active = !1
					}, "json")
				},
				closeModal: function() {
					this.ad_id = null, this.hash_id = "", this.user_id = "", this.camp_id = "", this.camp_theme = "", this.title = "", this.description = "", this.ad_url = "", this.action_text = "", this.img_url = "", this.img_width = "", this.img_height = "", this.cpc = "", this.cpv = "", this.payment_mode = "", this.status_message = "", this.type = "", this.reject_message = "", this.rejectMessageError = !1, this.button_success_active = !1, this.button_reject_active = !1, $(document).trigger("adflex.dt.reload")
				},
				init: function(t) {
					var e = this,
						a = {
							ad_id: t
						};
					$.getJSON("/api/admin/ads/get", a, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : (e.ad_id = t.data.ad_id, e.hash_id = t.data.hash_id, e.user_id = t.data.user_id, e.camp_id = t.data.camp_id, e.camp_theme = t.data.camp_theme, e.title = t.data.title, e.description = t.data.description, e.ad_url = t.data.ad_url, e.action_text = t.data.action_text, e.img_url = t.data.img_url, e.img_width = t.data.img_width, e.img_height = t.data.img_height, e.cpc = t.data.cpc, e.cpv = t.data.cpv, e.payment_mode = t.data.payment_mode, e.status_message = t.data.status_message, e.type = t.data.type, e.reject_message = t.data.status_message, e.$nextTick(function() {
							$(this.$el).find(".selectpicker").selectpicker("refresh"), this.camp_theme = $(this.$el).find(".selectpicker option:selected").text(), $(this.$el).modal()
						}))
					})
				},
				moderateNext: function() {
					var e = this,
						t = {
							ad_id: this.ad_id
						};
					$.getJSON("/api/admin/ads/get_unmoderate_ad", t, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : (e.ad_id = t.data.ad_id, e.hash_id = t.data.hash_id, e.user_id = t.data.user_id, e.camp_id = t.data.camp_id, e.camp_theme = t.data.camp_theme, e.title = t.data.title, e.description = t.data.description, e.ad_url = t.data.ad_url, e.action_text = t.data.action_text, e.img_url = t.data.img_url, e.img_width = t.data.img_width, e.img_height = t.data.img_height, e.cpc = t.data.cpc, e.cpv = t.data.cpv, e.payment_mode = t.data.payment_mode, e.status_message = t.data.status_message, e.type = t.data.type, e.reject_message = t.data.status_message, e.$nextTick(function() {
							$(this.$el).find(".selectpicker").selectpicker("refresh"), this.camp_theme = $(this.$el).find(".selectpicker2 option:selected").text(), $(this.$el).modal()
						}))
					})
				}
			}
		})
	}, {}],
	6: [function(t, e, a) {
		var i = t("./vue-edit-camp");
		$(document).on("click", ".camp-action", function() {
			var t = {
					camp_id: $(this).attr("data-id")
				},
				e = $(this).attr("data-action"),
				a = "";
			if("play" === e) a = "/api/admin/camp/play";
			else if("stop" === e) a = "/api/admin/camp/stop";
			else if("delete" === e && confirm("Confirm action?")) a = "/api/admin/camp/delete";
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
			url: "/api/admin/camp/fetch",
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
					return null === window.filter_user_id ? '<a href="/administrator/campaigns?user_id=' + a.user_id + '">' + a.username + "</a>" : a.username
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
		isPage("administrator/campaigns(.*)") && (t("./dt"), t("./actions"), t("./vue-add-camp"))
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
					$.getJSON("/api/admin/camp/get_camp_template", function(t) {
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
					this.button_active = !0, $.post("/api/admin/camp/add", this.$data, function(t) {
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
					$.getJSON("/api/admin/camp/get", {
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
					this.button_active = !0, $.post("/api/admin/camp/update", this.$data, function(t) {
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
		if(isPage("administrator/dashboard(.*)")) {
			var i = document.getElementById("finance-chart");
			new Chart(i, {
				type: "bar",
				data: {
					labels: chart_labels(30),
					datasets: [{
						label: "Payments",
						borderWidth: 0,
						backgroundColor: "#2980B9",
						data: chart_data(payments_chart, "amount", 30)
					}, {
						label: "Payouts",
						borderWidth: 0,
						backgroundColor: "#FF851B",
						data: chart_data(payouts_chart, "amount", 30)
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: !0
							},
							gridLines: {
								display: !1
							}
						}],
						xAxes: [{
							gridLines: {
								display: !1
							}
						}]
					},
					legend: {
						labels: {
							usePointStyle: !0
						}
					},
					tooltips: {
						mode: "index",
						itemSort: function() {
							return !0
						}
					}
				}
			});
			i = document.getElementById("views-chart");
			new Chart(i, {
				type: "line",
				data: {
					labels: chart_labels(30),
					datasets: [{
						label: "Views",
						borderWidth: 0,
						backgroundColor: "#DD4B39",
						data: chart_data(views_chart, "views", 30)
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: !0
							},
							gridLines: {
								display: !1
							}
						}],
						xAxes: [{
							gridLines: {
								display: !1
							}
						}]
					},
					legend: {
						labels: {
							usePointStyle: !0
						}
					},
					tooltips: {
						mode: "index",
						itemSort: function() {
							return !0
						}
					}
				}
			});
			i = document.getElementById("clicks-chart");
			new Chart(i, {
				type: "line",
				data: {
					labels: chart_labels(30),
					datasets: [{
						label: "Clicks",
						borderWidth: 0,
						backgroundColor: "#2980B9",
						data: chart_data(clicks_chart, "clicks", 30)
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: !0
							},
							gridLines: {
								display: !1
							}
						}],
						xAxes: [{
							gridLines: {
								display: !1
							}
						}]
					},
					legend: {
						labels: {
							usePointStyle: !0
						}
					},
					tooltips: {
						mode: "index",
						itemSort: function() {
							return !0
						}
					}
				}
			});
			i = document.getElementById("ctr-chart");
			new Chart(i, {
				type: "line",
				data: {
					labels: chart_labels(30),
					datasets: [{
						label: "CTR",
						borderWidth: 0,
						backgroundColor: "#27AE60",
						data: chart_data(ctr_chart, "ctr", 30)
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: !0
							},
							gridLines: {
								display: !1
							}
						}],
						xAxes: [{
							gridLines: {
								display: !1
							}
						}]
					},
					legend: {
						labels: {
							usePointStyle: !0
						}
					},
					tooltips: {
						mode: "index",
						itemSort: function() {
							return !0
						}
					}
				}
			})
		}
	}, {}],
	12: [function(t, e, a) {}, {}],
	13: [function(t, e, a) {
		e.exports = t(12)
	}, {}],
	14: [function(t, e, a) {
		isPage("administrator/faq(.*)") && (t("./dt"), t("./actions"))
	}, {
		"./actions": 12,
		"./dt": 13
	}],
	15: [function(t, e, a) {
		$(document).on("click", ".payment-details-btn", function() {
			var t = $(this).attr("data-payment-id");
			$.getJSON("/api/admin/payment/get", {
				payment_id: t
			}, function(t) {
				t.error ? ADFLEX.helpers.notifyError(t.message) : $(tmpl("payment-details-modal", t.data)).modal()
			})
		})
	}, {}],
	16: [function(t, e, a) {
		t("../../datatables")({
			url: "/api/admin/payment/fetch",
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
					return null === window.filter_user_id ? '<a href="/administrator/payments?user_id=' + a.user_id + '">' + a.username + "</a>" : a.username
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
		isPage("administrator/payments(.*)") && (t("./dt"), t("./actions"))
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
			url: "/api/admin/payout/fetch",
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
					return null === window.filter_user_id ? '<a href="/administrator/payouts?user_id=' + a.user_id + '">' + a.username + "</a>" : a.username
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
		isPage("administrator/payouts(.*)") && (t("./dt"), t("./actions"))
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
					$.getJSON("/api/admin/payout/get", {
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
					$.getJSON("/api/admin/payout/get", {
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
					this.success_button_active = !0, $.post("/api/admin/payout/end_success", this.$data, function(t) {
						t.error ? (notifyError(t.message), e.$refs.end_success.end()) : (notifySuccess(t.message), e.closeModal())
					}, "json")
				},
				end_error: function() {
					var e = this;
					this.error_button_active = !0, $.post("/api/admin/payout/end_error", this.$data, function(t) {
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
					$.getJSON("/api/admin/payout/get", {
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
					this.button_active = !0, $.post("/api/admin/payout/start", this.$data, function(t) {
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
		isPage("administrator/settings(.*)") && (t("./dt"), t("./actions"), t("./vue-settings"))
	}, {
		"./actions": 24,
		"./dt": 25,
		"./vue-settings": 27
	}],
	27: [function(t, e, a) {
		e.exports = new Vue({
			el: "#app-settings",
			data: {
				lang: null,
				timezone: null,
				enable_payouts: null,
				users_registration: null,
				paypal_payments: null,
				paypal_sandbox: 0,
				stripe_payments: null,
				comission: null,
				admin_paypal_account: null,
				admin_stripe_pub_key: null,
				admin_stripe_secret_key: null,
				old_password: null,
				new_password: null,
				customLogo: null,
				customName: null,
				customLogoFile: null,
				current_currency: null,
				adunit_visible_tip: null,
				button_active: !1,
				init: !1,
				isVisibleSaveBtn: !0
			},
			methods: {
				get: function() {
					var e = this;
					$.getJSON("/api/admin/settings/get", function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : (e.lang = t.data.lang, e.timezone = t.data.timezone, e.enable_payouts = t.data.enable_payouts, e.users_registration = t.data.users_registration, e.paypal_payments = t.data.paypal_payments, e.paypal_sandbox = t.data.paypal_sandbox, e.stripe_payments = t.data.stripe_payments, e.comission = t.data.comission, e.admin_paypal_account = t.data.admin_paypal_account, e.admin_stripe_pub_key = t.data.admin_stripe_pub_key, e.admin_stripe_secret_key = t.data.admin_stripe_secret_key, e.customName = t.data.customName, e.customLogo = t.data.customLogo, e.current_currency = t.data.current_currency, e.adunit_visible_tip = t.data.adunit_visible_tip, e.init = !0, e.$nextTick(function() {
							$(this.$el).find(".selectpicker").selectpicker("refresh")
						}))
					})
				},
				update: function() {
					this.button_active = !0;
					var a = new FormData;
					a.append("csrf", ADFLEX.csrf), _.each(this.$data, function(t, e) {
						"" !== t && null !== t && a.append(e, t)
					}), $.ajax({
						url: "/api/admin/settings/update",
						type: "POST",
						data: a,
						processData: !1,
						contentType: !1,
						dataType: "json",
						context: this,
						success: function(t) {
							t.error ? (ADFLEX.helpers.notifyError(t.message), this.button_active = !1) : (ADFLEX.helpers.notifySuccess(t.message), this.button_active = !1, setTimeout(function() {
								return location.reload()
							}, 1e3))
						}
					})
				},
				alertSandbox: function() {
					if(1 == this.paypal_sandbox) {
						var t = $("#paypal-sandbox-message").attr("title") ? $("#paypal-sandbox-message").attr("title") : $("#paypal-sandbox-message").attr("data-original-title");
						alert(t)
					}
				},
				processFile: function(t) {
					var e = this,
						a = new Image;
					a.src = window.URL.createObjectURL(t.target.files[0]), a.onload = function() {
						if(400 !== a.width || 100 !== a.height) return ADFLEX.helpers.notifyError(__("Неверный размер изображения! Размер должен быть 400x100 пикселей")), void $(t.target).val("");
						e.customLogo = a.src, e.customLogoFile = t.target.files[0]
					}
				},
				setCustomLogo: function() {
					if(this.customLogoFile) {
						this.button_active = !0;
						var t = new FormData;
						t.append("csrf", ADFLEX.csrf), t.append("customLogoFile", this.customLogoFile), $.ajax({
							url: "/api/admin/settings/set_custom_logo",
							type: "POST",
							data: t,
							processData: !1,
							contentType: !1,
							dataType: "json",
							context: this,
							success: function(t) {
								t.error ? (ADFLEX.helpers.notifyError(t.message), this.button_active = !1) : (this.button_active = !1, this.customLogo = t.data.customLogoUrl, this.update())
							}
						})
					} else this.update()
				}
			},
			computed: {
				paypal_payments_checkbox: function() {
					return null !== this.admin_paypal_account && -1 === this.admin_paypal_account.indexOf("@")
				},
				stripe_payments_checkbox: function() {
					return !(this.admin_stripe_pub_key && this.admin_stripe_secret_key)
				}
			},
			created: function() {
				this.get()
			},
			mounted: function() {
				var t = this;
				window.onhashchange = function() {
					"#t-tab-6" === window.location.hash ? t.isVisibleSaveBtn = !1 : t.isVisibleSaveBtn = !0
				}, window.onhashchange()
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
			if("play" === e) a = "/api/admin/site/play";
			else if("stop" === e) a = "/api/admin/site/stop";
			else if("ban" === e) {
				if(t.ban_message = prompt("Specify the reason for the ban.", ""), !t.ban_message) return;
				a = "/api/admin/site/ban"
			} else if("unban" === e) a = "/api/admin/site/unban";
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
			url: "/api/admin/site/fetch",
			data: {
				filter_user_id: window.filter_user_id
			},
			order: [
				[0, "desc"]
			],
			columns: [{
				data: "site_id"
			}, {
				data: "user_id"
			}, {
				data: "username",
				render: function(t, e, a) {
					return null === window.filter_user_id ? '<a href="/administrator/sites?user_id=' + a.user_id + '">' + a.username + "</a>" : a.username
				}
			}, {
				data: "domain",
				render: function(t, e, a) {
					t = ADFLEX.helpers.escapeHtml(t.substr(0, 30));
					return 1 == a.isolated ? '<a href="http://' + t + '" target="_blank">' + t + '</a>  <small class="label label-default"\n                                        style="position: relative; top:-5px"\n                                        data-toggle="tooltip"\n                                        data-title="Isolated site">\n                                            <i class="fa fa-lock"></i>\n                                       </small>' : '<a href="http://' + t + '" target="_blank">' + t + "</a>"
				}
			}, {
				data: "status",
				render: function(t, e, a, i) {
					return tmpl("site-status", a)
				}
			}, {
				data: "theme",
				render: function(t, e, a, i) {
					return tmpl("site-theme", a)
				}
			}, {
				data: "allowed_camp_themes",
				sortable: !1,
				render: function(t, e, a, i) {
					var n = window.ADFLEX.themes,
						s = a.allowed_camp_themes.split(","),
						r = {
							count_all_themes: n.length,
							count_enabled_themes: s.length,
							count_disabled_themes: n.length - s.length,
							themes: JSON.stringify({
								domain: a.domain,
								enabled: s,
								disabled: $(n).not(s).get()
							})
						};
					return tmpl("site-allowed-camp-themes", r)
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a, i) {
					return tmpl("site-actions", a)
				}
			}]
		})
	}, {
		"../../datatables": 87
	}],
	30: [function(t, e, a) {
		isPage("administrator/sites(.*)") && (t("./dt"), t("./actions"), t("./vue-add-site"))
	}, {
		"./actions": 28,
		"./dt": 29,
		"./vue-add-site": 31
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
					this.button_active = !0, $.post("/api/admin/site/add", this.$data, function(t) {
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
					this.button_active = !0, $.post("/api/admin/site/update", this.$data, function(t) {
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
					$.getJSON("/api/admin/site/get", {
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
						this.button_reject_active = !0, $.post("/api/admin/site/moderate", t, function(t) {
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
					this.button_success_active = !0, $.post("/api/admin/site/moderate", t, function(t) {
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
					$.getJSON("/api/admin/site/get", a, function(t) {
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
	35: [function(t, e, a) {
		isPage("administrator/statistics") && t("../../datatables")({
			url: "/api/admin/stat/days",
			order: [
				[1, "desc"]
			],
			columns: [{
				data: null,
				sortable: !1,
				render: function(t, e, a, i) {
					return i.row + 1
				}
			}, {
				data: "date",
				render: function(t) {
					return moment(t).format("YYYY-MM-DD")
				}
			}, {
				data: "views"
			}, {
				data: "clicks"
			}, {
				data: "ctr",
				render: function(t) {
					return parseFloat(t).toFixed(2)
				}
			}]
		}), isPage("administrator/statistics/webmasters") && t("../../datatables")({
			url: "/api/admin/stat/webmasters",
			order: [
				[0, "asc"]
			],
			group: ["user_id"],
			data: {
				start_date: function() {
					return localStorage.getItem("start_date")
				},
				end_date: function() {
					return localStorage.getItem("end_date")
				},
				filter_user_id: window.filter_user_id
			},
			columns: [{
				data: "user_id",
				render: function(t) {
					return t + '<a class="btn btn-xs btn-default pull-right" target="_blank" href="/administrator/users?searchquery=' + t + '">\n                        <i class="fa fa-search"></i>\n                    </a>'
				}
			}, {
				data: "views|SUM"
			}, {
				data: "clicks|SUM"
			}, {
				data: "ctr|AVG",
				render: function(t) {
					return parseFloat(t).toFixed(2)
				}
			}, {
				data: "profit|SUM",
				render: function(t) {
					return parseFloat(t).toFixed(4) + " " + window.current_currency
				}
			}]
		}), isPage("administrator/statistics/sites") && t("../../datatables")({
			url: "/api/admin/stat/sites",
			order: [
				[0, "asc"]
			],
			group: ["site_id", "user_id"],
			data: {
				start_date: function() {
					return localStorage.getItem("start_date")
				},
				end_date: function() {
					return localStorage.getItem("end_date")
				},
				filter_user_id: window.filter_user_id
			},
			columns: [{
				data: "site_id",
				render: function(t) {
					return t + ' <a class="btn btn-xs btn-default pull-right" target="_blank" href="/administrator/sites?searchquery=' + t + '">\n                        <i class="fa fa-search"></i>\n                    </a>'
				}
			}, {
				data: "user_id",
				render: function(t) {
					return '<a href="/administrator/statistics/sites?user_id=' + t + '">' + t + '</a>\n                    <a class="btn btn-xs btn-default pull-right" target="_blank" href="/administrator/users?searchquery=' + t + '">\n                        <i class="fa fa-search"></i>\n                    </a>'
				}
			}, {
				data: "views|SUM"
			}, {
				data: "clicks|SUM"
			}, {
				data: "ctr|AVG",
				render: function(t) {
					return parseFloat(t).toFixed(2)
				}
			}, {
				data: "cpm|AVG",
				render: function(t) {
					return parseFloat(t).toFixed(2)
				}
			}, {
				data: "profit|SUM",
				render: function(t) {
					return parseFloat(t).toFixed(4)
				}
			}]
		}), isPage("administrator/statistics/advertisers") && t("../../datatables")({
			url: "/api/admin/stat/advertisers",
			order: [
				[0, "asc"]
			],
			group: ["user_id"],
			data: {
				start_date: function() {
					return localStorage.getItem("start_date")
				},
				end_date: function() {
					return localStorage.getItem("end_date")
				},
				filter_user_id: window.filter_user_id
			},
			columns: [{
				data: "user_id",
				render: function(t) {
					return t + '<a class="btn btn-xs btn-default pull-right" target="_blank" href="/administrator/users?searchquery=' + t + '">\n                        <i class="fa fa-search"></i>\n                    </a>'
				}
			}, {
				data: "views|SUM"
			}, {
				data: "clicks|SUM"
			}, {
				data: "ctr|AVG",
				render: function(t) {
					return parseFloat(t).toFixed(2)
				}
			}, {
				data: "costs|SUM",
				render: function(t) {
					return parseFloat(t).toFixed(4) + " " + window.current_currency
				}
			}]
		}), isPage("administrator/statistics/camps") && t("../../datatables")({
			url: "/api/admin/stat/camps",
			order: [
				[0, "asc"]
			],
			group: ["camp_id", "user_id"],
			data: {
				start_date: function() {
					return localStorage.getItem("start_date")
				},
				end_date: function() {
					return localStorage.getItem("end_date")
				},
				filter_user_id: window.filter_user_id
			},
			columns: [{
				data: "camp_id",
				render: function(t) {
					return t + ' <a class="btn btn-xs btn-default pull-right" target="_blank" href="/administrator/campaigns?searchquery=' + t + '">\n                        <i class="fa fa-search"></i>\n                    </a>'
				}
			}, {
				data: "user_id",
				render: function(t) {
					return '<a href="/administrator/statistics/camps?user_id=' + t + '">' + t + '</a>\n                    <a class="btn btn-xs btn-default pull-right" target="_blank" href="/administrator/users?searchquery=' + t + '">\n                        <i class="fa fa-search"></i>\n                    </a>'
				}
			}, {
				data: "views|SUM"
			}, {
				data: "clicks|SUM"
			}, {
				data: "ctr|AVG",
				render: function(t) {
					return parseFloat(t).toFixed(2)
				}
			}, {
				data: "cpm|AVG",
				render: function(t) {
					return parseFloat(t).toFixed(2)
				}
			}, {
				data: "costs|SUM",
				render: function(t) {
					return parseFloat(t).toFixed(4) + " " + window.current_currency
				}
			}]
		}), isPage("administrator/statistics/units") && t("../../datatables")({
			url: "/api/admin/stat/units",
			order: [
				[0, "asc"]
			],
			group: ["unit_id", "site_id", "user_id"],
			data: {
				start_date: function() {
					return localStorage.getItem("start_date")
				},
				end_date: function() {
					return localStorage.getItem("end_date")
				},
				filter_user_id: window.filter_user_id,
				filter_site_id: window.filter_site_id
			},
			columns: [{
				data: "unit_id"
			}, {
				data: "site_id",
				render: function(t) {
					return '<a href="/administrator/statistics/units?site_id=' + t + '">' + t + '</a>\n                    <a class="btn btn-xs btn-default pull-right" target="_blank" href="/administrator/sites?searchquery=' + t + '">\n                        <i class="fa fa-search"></i>\n                    </a>'
				}
			}, {
				data: "user_id",
				render: function(t) {
					return '<a href="/administrator/statistics/units?user_id=' + t + '">' + t + '</a>\n                    <a class="btn btn-xs btn-default pull-right" target="_blank" href="/administrator/users?searchquery=' + t + '">\n                        <i class="fa fa-search"></i>\n                    </a>'
				}
			}, {
				data: "views|SUM"
			}, {
				data: "clicks|SUM"
			}, {
				data: "ctr|AVG",
				render: function(t) {
					return parseFloat(t).toFixed(2)
				}
			}, {
				data: "cpm|AVG",
				render: function(t) {
					return parseFloat(t).toFixed(2)
				}
			}, {
				data: "profit|SUM",
				render: function(t) {
					return parseFloat(t).toFixed(4) + " " + window.current_currency
				}
			}]
		}), isPage("administrator/statistics/ads") && t("../../datatables")({
			url: "/api/admin/stat/ads",
			order: [
				[0, "asc"]
			],
			group: ["ad_id", "camp_id", "user_id"],
			data: {
				start_date: function() {
					return localStorage.getItem("start_date")
				},
				end_date: function() {
					return localStorage.getItem("end_date")
				},
				filter_user_id: window.filter_user_id,
				filter_camp_id: window.filter_camp_id
			},
			columns: [{
				data: "ad_id",
				render: function(t) {
					return t + ' <a class="btn btn-xs btn-default pull-right" target="_blank" href="/administrator/ads?searchquery=' + t + '">\n                        <i class="fa fa-search"></i>\n                    </a>'
				}
			}, {
				data: "camp_id",
				render: function(t) {
					return '<a href="/administrator/statistics/ads?camp_id=' + t + '">' + t + '</a>\n                    <a class="btn btn-xs btn-default pull-right" target="_blank" href="/administrator/campaigns?searchquery=' + t + '">\n                        <i class="fa fa-search"></i>\n                    </a>'
				}
			}, {
				data: "user_id",
				render: function(t) {
					return '<a href="/administrator/statistics/ads?user_id=' + t + '">' + t + '</a>\n                    <a class="btn btn-xs btn-default pull-right" target="_blank" href="/administrator/users?searchquery=' + t + '">\n                        <i class="fa fa-search"></i>\n                    </a>'
				}
			}, {
				data: "views|SUM"
			}, {
				data: "clicks|SUM"
			}, {
				data: "ctr|AVG",
				render: function(t) {
					return parseFloat(t).toFixed(2)
				}
			}, {
				data: "cpm|AVG",
				render: function(t) {
					return parseFloat(t).toFixed(2)
				}
			}, {
				data: "costs|SUM",
				render: function(t) {
					return parseFloat(t).toFixed(4) + " " + window.current_currency
				}
			}]
		})
	}, {
		"../../datatables": 87
	}],
	36: [function(t, e, a) {
		isPage("administrator/statistics(.*)") && (t("./dt"), t("./actions"))
	}, {
		"./actions": 34,
		"./dt": 35
	}],
	37: [function(e, t, a) {
		var i = $(window).height() - 350;

		function n(t, e) {
			var a = {
				ticket_id: t
			};
			$.post("/api/admin/ticket/" + e, a, function(t) {
				t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), $(document).trigger("adflex.dt.reload")
			}, "json")
		}
		$(".direct-chat-messages").css("max-height", i + "px"), $(document).on("click", ".ticket-messages", function() {
			var t = $(this).attr("data-id");
			e("./vue-ticket-messages").init(t)
		}), $(document).on("click", ".item-action", function() {
			var t = $(this).attr("data-id"),
				e = $(this).attr("data-action");
			"close" === e && confirm("Confirm action?") ? n(t, e) : "open" === e && confirm("Confirm action?") && n(t, e)
		})
	}, {
		"./vue-ticket-messages": 41
	}],
	38: [function(t, e, a) {
		t("../../datatables")({
			url: "/api/admin/ticket/fetch",
			data: {
				filter_user_id: window.filter_user_id
			},
			order: [
				[0, "desc"]
			],
			columns: [{
				data: "ticket_id"
			}, {
				data: "user_id"
			}, {
				data: "username",
				render: function(t, e, a) {
					return null === window.filter_user_id ? '<a href="/administrator/support?user_id=' + a.user_id + '">' + a.username + "</a>" : a.username
				}
			}, {
				data: "email"
			}, {
				data: "subject",
				render: function(t, e, a) {
					return t.slice(0, 20) + "..."
				}
			}, {
				data: "status",
				render: function(t, e, a) {
					return tmpl("status", a)
				}
			}, {
				data: "date_open",
				render: function(t) {
					return toLocalDate(t)
				}
			}, {
				data: "closed_at",
				render: function(t) {
					return Date.parse(t) ? toLocalDate(t) : ""
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a) {
					return tmpl("messages", a)
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a) {
					return tmpl("actions", a)
				}
			}]
		})
	}, {
		"../../datatables": 87
	}],
	39: [function(t, e, a) {
		isPage("administrator/support(.*)") && (t("./dt"), t("./actions"), t("./vue-create-ticket"))
	}, {
		"./actions": 37,
		"./dt": 38,
		"./vue-create-ticket": 40
	}],
	40: [function(t, e, a) {
		e.exports = new Vue({
			el: "#add-ticket",
			data: {
				message: "",
				subject: "",
				user_id: null,
				button_active: !1
			},
			methods: {
				createTicket: function() {
					var e = this;
					this.button_active = !0, $.post("/api/admin/ticket/add", this.$data, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (e.user_id = "", e.message = "", e.subject = "", e.button_active = !1, ADFLEX.helpers.notifySuccess(t.message))
					}, "json")
				},
				closeModal: function() {
					this.message = "", this.subject = "", this.user_id = null, this.button_active = !1, $(document).trigger("adflex.dt.reload")
				}
			}
		})
	}, {}],
	41: [function(t, e, a) {
		e.exports = new Vue({
			el: "#ticket-messages",
			data: {
				messages: [],
				message: "",
				ticket_id: null,
				subject: null,
				status: null,
				user_id: null,
				button_active: !1
			},
			methods: {
				init: function(t) {
					var e = this;
					this.getTicket(t, function() {
						e.getMessages(), $(e.$el).modal()
					})
				},
				getTicket: function(t, e) {
					var a = this,
						i = {
							ticket_id: t
						};
					$.post("/api/admin/ticket/get", i, function(t) {
						return t.error ? (ADFLEX.helpers.notifyError(t.message), void(a.button_active = !1)) : (a.ticket_id = t.data.ticket_id, a.user_id = t.data.user_id, a.subject = t.data.subject, a.status = t.data.status, e())
					}, "json")
				},
				getMessages: function() {
					var e = this,
						t = {
							ticket_id: this.ticket_id
						};
					$.post("/api/admin/message/fetch", t, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (e.messages = t.data, e.message = "", e.$nextTick(function() {
							e.scrollEnd()
						}))
					}, "json")
				},
				sendMessage: function() {
					var e = this;
					this.button_active = !0;
					var t = {
						ticket_id: this.ticket_id,
						message: this.message
					};
					$.post("/api/admin/message/send", t, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1, e.getMessages())
					}, "json")
				},
				scrollEnd: function() {
					var t = $(".direct-chat-messages");
					t.scrollTop(t[0].scrollHeight)
				},
				closeModal: function() {
					this.messages = [], this.message = "", this.ticket_id = null, this.subject = null, this.status = null, this.user_id = null, this.button_active = !1, $(document).trigger("adflex.dt.reload")
				},
				closeTicket: function() {
					var e = this;
					if(confirm("Confirm action?")) {
						var t = {
							ticket_id: this.ticket_id
						};
						$.post("/api/admin/ticket/close", t, function(t) {
							t.error ? ADFLEX.helpers.notifyError(t.message) : (ADFLEX.helpers.notifySuccess(t.message), $(e.$el).modal("hide"), $(document).trigger("adflex.dt.reload"))
						}, "json")
					}
				}
			}
		})
	}, {}],
	42: [function(t, e, a) {
		var n = t("./vue-bannerunit"),
			s = t("./vue-mobileunit"),
			r = t("./vue-adunit");
		$(document).on("click", ".admin-adunit-action", function(t) {
			var e = {
					units_ids: $(this).attr("data-id"),
					csrf: ADFLEX.csrf
				},
				a = $(this).attr("data-action"),
				i = "";
			"play" === a ? i = ADFLEX.url.admin_play_adunit : "stop" === a ? i = ADFLEX.url.admin_stop_adunit : "delete" === a ? $(document).trigger("admin-delete-adunit-confirm", {
				ids: [e.units_ids]
			}) : "edit" === a && ("banner" === $(this).attr("data-adunit-type") ? n.editBannerUnit(e.units_ids) : "mobile" === $(this).attr("data-adunit-type") ? s.editMobileUnit(e.units_ids) : "ads" === $(this).attr("data-adunit-type") && r.editAdsUnit(e.units_ids)), $.post(i, e, function(t) {
				t.error ? ADFLEX.helpers.notifyError(t.message) : location.reload()
			}, "json")
		}), $(document).on("change", "#admin-adunits-check-all", function() {
			$(this).prop("checked") ? $(".admin-adunit-check").prop("checked", !0) : $(".admin-adunit-check").prop("checked", !1)
		}), $(document).on("click", ".pagination", function() {
			$("#admin-adunits-check-all,.admin-adunit-check").prop("checked", !1)
		}), $(document).on("change", "#admin-adunits-multi-actions", function() {
			var t = "",
				e = $(this).val(),
				a = [];
			if($(".admin-adunit-check:checked").each(function() {
					a.push(this.value)
				}), 0 !== a.length) {
				if("play" === e) t = ADFLEX.url.admin_play_adunit;
				else if("stop" === e) t = ADFLEX.url.admin_stop_adunit;
				else if("delete" === e) $(document).trigger("admin-delete-adunit-confirm", {
					ids: a
				});
				else if("---" === e) return;
				var i = {
					units_ids: a.join(","),
					csrf: ADFLEX.csrf
				};
				$.post(t, i, function(t) {
					t.error ? ADFLEX.helpers.notifyError(t.message) : location.reload()
				}, "json")
			} else $(this).val("---")
		}), $(document).on("admin-delete-adunit-confirm", function(t, a) {
			bootbox.confirm({
				title: "Confirm action",
				message: "Do you confirm the deletion?",
				callback: function(t) {
					if(t) {
						var e = {
							units_ids: a.ids.join(","),
							csrf: ADFLEX.csrf
						};
						$.post(ADFLEX.url.admin_delete_adunit, e, function(t) {
							t.error ? ADFLEX.helpers.notifyError(t.message) : location.reload()
						}, "json")
					}
				}
			})
		}), $(document).on("click", ".admin-get-adunit-code-button", function(t, e) {
			var a = '<div class="adflexbox" id="' + $(this).attr("data-unit-hash-id") + '"></div>\n<script>\n    (function(d, w) {\n        if (!w.adflex) {\n            var s = d.createElement("script");\n            s.type = "text/javascript";\n            s.src = "' + location.href.split("/")[0] + "//" + location.host + "/loader.js\";\n            d.getElementsByTagName('head')[0].appendChild(s);\n            w.adflex = {};\n        }\n    })(document, window);\n<\/script>";
			$("#admin-get-adunit-code").find("textarea").val(a).end().modal({
				backdrop: "static"
			})
		}), $("#admin-copy-adunit-code-btn").tooltip({
			placement: "top",
			trigger: "manual"
		}), $("#admin-copy-adunit-code-btn").on("click", function() {
			$(this).tooltip("show");
			var t = $("#admin-get-adunit-code").find("textarea");
			t.get(0).focus(), t.get(0).select(), copy(t.val())
		}).mouseout(function() {
			$(this).tooltip("hide")
		}), $("#admin-get-adunit-code").on("click", "textarea", function() {
			$(this).get(0).select()
		})
	}, {
		"./vue-adunit": 46,
		"./vue-bannerunit": 47,
		"./vue-mobileunit": 48
	}],
	43: [function(t, e, a) {
		var i = !1;
		$("#admin-adunitslist").DataTable({
			order: [
				[1, "desc"]
			],
			ajax: {
				url: ADFLEX.url.admin_get_all_adunits,
				data: {
					site_id: window.location.href.split("/")[4].replace(/\#.*/, ""),
					csrf: ADFLEX.csrf
				},
				dataSrc: function(t) {
					return t.error ? (alert(t.message), !1) : t.data
				}
			},
			fnDrawCallback: function(t) {
				0 < t.aoData.length && $("#admin-adunitslist-wrapper").removeClass("hidden"), i || ($("#admin-adunitslist_length").prepend(tmpl("admin-adunits-multi-actions")), i = !0), $("#admin-adunits-multi-actions").val("---"), $("#admin-adunits-check-all").prop("checked", !1)
			},
			processing: !0,
			keepConditions: !0,
			columns: [{
				data: "unit_id",
				sortable: !1,
				render: function(t) {
					return '<input type="checkbox"\n                            class="admin-adunit-check"\n                            name="admin-adunit-check[]"\n                            value="' + t + '">'
				}
			}, {
				data: "unit_id"
			}, {
				data: "name",
				render: function(t) {
					return ADFLEX.helpers.escapeHtml(t.substr(0, 30))
				}
			}, {
				data: "status",
				render: function(t, e, a, i) {
					return tmpl("admin-adunit-status", a)
				}
			}, {
				data: "type",
				render: function(t, e, a, i) {
					return tmpl("admin-adunit-type", a)
				}
			}, {
				data: "banner_size",
				render: function(t) {
					return t || "Adaptive"
				}
			}, {
				data: "allowed_payments",
				render: function(t) {
					var e, a = t.split(",");
					return e = a[0] ? '<small class="label bg-navy">' + a[0] + "</small> " : "", e += a[1] ? '<small class="label label-default">' + a[1] + "</small>" : ""
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a, i) {
					return tmpl("admin-adunit-get-code", a)
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a, i) {
					return tmpl("admin-adunit-actions", a)
				}
			}]
		})
	}, {}],
	44: [function(t, e, a) {
		isPage("administrator/units(.*)") && (t("./dt"), t("./actions"), t("./other"), t("./vue-bannerunit.js"), t("./vue-mobileunit"), t("./vue-adunit"))
	}, {
		"./actions": 42,
		"./dt": 43,
		"./other": 45,
		"./vue-adunit": 46,
		"./vue-bannerunit.js": 47,
		"./vue-mobileunit": 48
	}],
	45: [function(t, e, a) {
		$(function() {
			$(".colorpicker-component").colorpicker({
				format: "hex"
			}).on("hidePicker", function() {
				$(this).find("input").trigger("click")
			}), $('a[href="#tab_2"]').on("click", function() {
				$(this).parents(".modal-dialog").animate({
					width: "95%"
				})
			}), $('a[href="#tab_1"]').on("click", function() {
				$(this).parents(".modal-dialog").animate({
					width: "600px"
				})
			}), $(".webmaster-adunit-iframe-preview").resizable({
				handleSelector: ".splitter",
				resizeHeight: !1
			})
		})
	}, {}],
	46: [function(t, e, a) {
		e.exports = new Vue({
			el: "#admin-add-adsunit",
			data: {
				unit_id: null,
				site_id: null,
				name: "",
				type: "ads",
				min_cpc: "0.01",
				min_cpv: "1.00",
				allowed_payments: ["cpc", "cpv"],
				params: {
					third_party_status: !1,
					third_party_code: "",
					form_factor: "vertical",
					count_ads: 2,
					unit_bgcolor: "#00AABB",
					unit_bordercolor: "#cccccc",
					font_family: "inherit",
					title_color: "#3C8DBC",
					description_color: "#4C4C4C",
					button_color: ""
				},
				button_active: !1,
				is_complete: !1,
				is_edit: !1
			},
			methods: {
				inputCPC: function() {
					var t = parseFloat(this.min_cpc).toFixed(2);
					isNaN(t) ? this.min_cpc = "0.01" : this.min_cpc = 100 < t ? "100.00" : t < .01 ? "0.01" : t
				},
				inputCPV: function() {
					var t = parseFloat(this.min_cpv).toFixed(2);
					isNaN(t) ? this.min_cpv = "0.50" : this.min_cpv = 100 < t ? "100.00" : t < .01 ? "0.50" : t
				},
				addAdsUnit: function() {
					var e = this,
						t = {
							unit_id: this.unit_id,
							site_id: this.site_id,
							name: this.name,
							type: this.type,
							min_cpc: this.min_cpc,
							min_cpv: this.min_cpv,
							allowed_payments: this.allowed_payments,
							params: this.params,
							csrf: ADFLEX.csrf
						};
					this.button_active = !0, this.is_edit ? $.post(ADFLEX.url.admin_edit_adunit, t, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1, e.is_complete = !0)
					}, "json") : $.post(ADFLEX.url.admin_add_adunit, t, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1, e.is_complete = !0, e.is_edit = !0, e.unit_id = t.unit_id)
					}, "json")
				},
				editAdsUnit: function(t) {
					var e = this;
					this.is_edit = !0;
					var a = {
						csrf: ADFLEX.csrf,
						unit_id: t
					};
					$.getJSON(ADFLEX.url.admin_get_adunit, a, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : (e.unit_id = t.data.unit_id, e.site_id = t.data.site_id, e.name = ADFLEX.helpers.escapeHtml(t.data.name), e.type = t.data.type, e.min_cpc = t.data.min_cpc, e.min_cpv = t.data.min_cpv, e.allowed_payments = t.data.allowed_payments.split(","), e.params = JSON.parse(t.data.params), e.$nextTick(function() {
							$(this.$el).find(".selectpicker").selectpicker("refresh"), $(".colorpicker-component").each(function() {
								$(this).colorpicker("setValue", $(this).colorpicker("getValue"))
							})
						}), $("#admin-add-adsunit").modal())
					})
				},
				closeModal: function() {
					location.reload()
				}
			},
			computed: {
				iframeLink: function() {
					var t = [];
					for(var e in this.params) t.push(e + "=" + encodeURIComponent(this.params[e]));
					return "/adprovider/adunit_preview/?" + t.join("&")
				}
			},
			created: function() {
				this.name = "Ad-unit - " + Math.random().toString().slice(2, 7), this.site_id = window.location.href.split("/")[4].replace(/\#.*/, ""), this.params.button_color = this.params.title_color
			},
			watch: {
				"params.third_party_status": function(t) {
					this.params.third_party_status = "true" === t || !0 === t
				},
				"params.title_color": function(t) {
					this.params.button_color = t
				}
			}
		})
	}, {}],
	47: [function(t, e, a) {
		e.exports = new Vue({
			el: "#admin-add-bannerunit",
			data: {
				unit_id: null,
				site_id: null,
				name: "",
				type: "banner",
				min_cpc: "0.01",
				min_cpv: "1.00",
				banner_size: "300x250",
				allowed_payments: ["cpc", "cpv"],
				allowed_banners_sizes: ADFLEX.banners_sizes,
				params: {
					third_party_status: !1,
					third_party_code: ""
				},
				button_active: !1,
				is_complete: !1,
				is_edit: !1
			},
			methods: {
				inputCPC: function() {
					var t = parseFloat(this.min_cpc).toFixed(2);
					isNaN(t) ? this.min_cpc = "0.01" : this.min_cpc = 100 < t ? "100.00" : t < .01 ? "0.01" : t
				},
				inputCPV: function() {
					var t = parseFloat(this.min_cpv).toFixed(2);
					isNaN(t) ? this.min_cpv = "0.50" : this.min_cpv = 100 < t ? "100.00" : t < .01 ? "0.50" : t
				},
				addBannerUnit: function() {
					var e = this,
						t = {
							unit_id: this.unit_id,
							site_id: this.site_id,
							name: this.name,
							type: this.type,
							min_cpc: this.min_cpc,
							min_cpv: this.min_cpv,
							banner_size: this.banner_size,
							allowed_payments: this.allowed_payments,
							params: this.params,
							csrf: ADFLEX.csrf
						};
					this.button_active = !0, this.is_edit ? $.post(ADFLEX.url.admin_edit_adunit, t, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1, e.is_complete = !0)
					}, "json") : $.post(ADFLEX.url.admin_add_adunit, t, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1, e.is_complete = !0, e.is_edit = !0, e.unit_id = t.unit_id)
					}, "json")
				},
				editBannerUnit: function(t) {
					var e = this;
					this.is_edit = !0;
					var a = {
						csrf: ADFLEX.csrf,
						unit_id: t
					};
					$.getJSON(ADFLEX.url.admin_get_adunit, a, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : (e.unit_id = t.data.unit_id, e.site_id = t.data.site_id, e.name = ADFLEX.helpers.escapeHtml(t.data.name), e.type = t.data.type, e.min_cpc = t.data.min_cpc, e.min_cpv = t.data.min_cpv, e.banner_size = t.data.banner_size, e.allowed_payments = t.data.allowed_payments.split(","), e.params = JSON.parse(t.data.params), console.log(e.params), e.$nextTick(function() {
							$(this.$el).find(".selectpicker").selectpicker("refresh")
						}), $("#admin-add-bannerunit").modal())
					})
				},
				closeModal: function() {
					location.reload()
				}
			},
			created: function() {
				this.name = "Banner-unit - " + Math.random().toString().slice(2, 7), this.site_id = window.location.href.split("/")[4].replace(/\#.*/, "")
			},
			watch: {
				"params.third_party_status": function(t) {
					this.params.third_party_status = "true" === t || !0 === t
				}
			}
		})
	}, {}],
	48: [function(t, e, a) {
		e.exports = new Vue({
			el: "#admin-add-mobileunit",
			data: {
				unit_id: null,
				site_id: null,
				name: "",
				type: "mobile",
				min_cpc: "0.01",
				min_cpv: "1.00",
				allowed_payments: ["cpc", "cpv"],
				params: {
					position: "bottom",
					show_delay: 0,
					hidden_period: 60
				},
				button_active: !1,
				is_complete: !1,
				is_edit: !1
			},
			methods: {
				inputCPC: function() {
					var t = parseFloat(this.min_cpc).toFixed(2);
					isNaN(t) ? this.min_cpc = "0.01" : this.min_cpc = 100 < t ? "100.00" : t < .01 ? "0.01" : t
				},
				inputCPV: function() {
					var t = parseFloat(this.min_cpv).toFixed(2);
					isNaN(t) ? this.min_cpv = "0.50" : this.min_cpv = 100 < t ? "100.00" : t < .01 ? "0.50" : t
				},
				addMobileUnit: function() {
					var e = this,
						t = {
							unit_id: this.unit_id,
							site_id: this.site_id,
							name: this.name,
							type: this.type,
							min_cpc: this.min_cpc,
							min_cpv: this.min_cpv,
							params: this.params,
							allowed_payments: this.allowed_payments,
							csrf: ADFLEX.csrf
						};
					this.button_active = !0, this.is_edit ? $.post(ADFLEX.url.admin_edit_adunit, t, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1, e.is_complete = !0)
					}, "json") : $.post(ADFLEX.url.admin_add_adunit, t, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1, e.is_complete = !0)
					}, "json")
				},
				editMobileUnit: function(t) {
					var e = this;
					this.is_edit = !0;
					var a = {
						csrf: ADFLEX.csrf,
						unit_id: t
					};
					$.getJSON(ADFLEX.url.admin_get_adunit, a, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : (e.unit_id = t.data.unit_id, e.site_id = t.data.site_id, e.name = ADFLEX.helpers.escapeHtml(t.data.name), e.type = t.data.type, e.params = JSON.parse(t.data.params), e.min_cpc = t.data.min_cpc, e.min_cpv = t.data.min_cpv, e.banner_size = t.data.banner_size, e.allowed_payments = t.data.allowed_payments.split(","), e.$nextTick(function() {
							$(this.$el).find(".selectpicker").selectpicker("refresh")
						}), $("#admin-add-mobileunit").modal())
					})
				},
				closeModal: function() {
					location.reload()
				},
				inputShowDelay: function() {
					var t = parseInt(this.params.show_delay);
					isNaN(t) ? this.params.show_delay = 0 : this.params.show_delay = 360 < t ? 360 : t < 0 ? 0 : t
				},
				inputHiddenPeriod: function() {
					var t = parseInt(this.params.hidden_period);
					isNaN(t) ? this.params.hidden_period = 0 : this.params.hidden_period = 86400 < t ? 86400 : t < 0 ? 0 : t
				}
			},
			created: function() {
				this.name = "Mobile-unit - " + Math.random().toString().slice(2, 7), this.site_id = window.location.href.split("/")[4].replace(/\#.*/, "")
			}
		})
	}, {}],
	49: [function(t, e, a) {
		var i = t("./vue-role-user"),
			n = t("./vue-balance-user");

		function s(t, e) {
			var a = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : "";
			$.post("/api/admin/user/" + e, {
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
			} else "unban" === e ? s(t, e) : "edit-role" === e ? i.init(t) : "edit-balance" === e && n.init(t)
		})
	}, {
		"./vue-balance-user": 53,
		"./vue-role-user": 54
	}],
	50: [function(t, e, a) {
		t("../../datatables")({
			url: "/api/admin/user/fetch",
			order: [
				[0, "desc"]
			],
			columns: [{
				data: "id"
			}, {
				data: "username"
			}, {
				data: "email"
			}, {
				data: "role",
				render: function(t, e, a) {
					return tmpl("role", a)
				}
			}, {
				data: "status",
				render: function(t, e, a) {
					return tmpl("status", a)
				}
			}, {
				data: "webmaster_balance",
				render: function(t, e, a) {
					return "administrator" == a.role ? "" : numeral(t).format("0,0.00") + " " + window.current_currency.toUpperCase()
				}
			}, {
				data: "advertiser_balance",
				render: function(t, e, a) {
					return "administrator" == a.role ? "" : numeral(t).format("0,0.00") + " " + window.current_currency.toUpperCase()
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a) {
					return tmpl("info", a)
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a) {
					return "administrator" == a.role ? "" : tmpl("to-account", a)
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a) {
					return "administrator" == a.role ? "" : tmpl("actions", a)
				}
			}]
		})
	}, {
		"../../datatables": 87
	}],
	51: [function(t, e, a) {
		isPage("administrator/users(.*)") && (t("./dt"), t("./actions"), t("./vue-add-user"))
	}, {
		"./actions": 49,
		"./dt": 50,
		"./vue-add-user": 52
	}],
	52: [function(t, e, a) {
		e.exports = new Vue({
			el: "#add-user",
			data: {
				username: "",
				email: "",
				password: "",
				subrole: "webmaster",
				button_active: !1,
				is_complete: !1,
				emailNotise: !1
			},
			methods: {
				randomPassword: function() {
					for(var t = "abcdefghijklmnopqrstuvwxyz!@#$%*()-+<>ABCDEFGHIJKLMNOP1234567890", e = "", a = 0; a < 10; a++) {
						var i = Math.floor(Math.random() * t.length);
						e += t.charAt(i)
					}
					this.password = e
				},
				randomUsername: function() {
					var t = "User_" + Math.random().toString().slice(2, 7).toUpperCase();
					this.username = t
				},
				addUser: function() {
					var e = this;
					this.button_active = !0, $.post("/api/admin/user/add", this.$data, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1, e.is_complete = !0)
					}, "json")
				},
				closeModal: function() {
					this.username = "", this.email = "", this.password = "", this.subrole = "webmaster", this.button_active = !1, this.is_complete = !1, this.emailNotise = !1, $(document).trigger("adflex.dt.reload")
				}
			}
		})
	}, {}],
	53: [function(t, e, a) {
		e.exports = new Vue({
			el: "#balance-user",
			data: {
				id: null,
				username: "",
				email: "",
				role: "",
				new_webmaster_balance: "",
				new_advertiser_balance: "",
				webmaster_balance: "",
				advertiser_balance: "",
				webmaster_diff: "",
				advertiser_diff: "",
				currency: "",
				button_active: !1,
				complete: !1
			},
			methods: {
				init: function(t) {
					var e = this;
					$.post("/api/admin/user/get", {
						id: t
					}, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : (e.id = t.data.id, e.username = t.data.username, e.email = t.data.email, e.role = t.data.role, e.subrole = t.data.subrole, e.new_webmaster_balance = t.data.webmaster_balance, e.new_advertiser_balance = t.data.advertiser_balance, e.webmaster_balance = t.data.webmaster_balance, e.advertiser_balance = t.data.advertiser_balance, e.currency = window.current_currency, $(e.$el).modal())
					}, "json")
				},
				webmasterDownBalance: function() {
					this.new_webmaster_balance = parseFloat(this.new_webmaster_balance) - 1
				},
				webmasterUpBalance: function() {
					this.new_webmaster_balance = parseFloat(this.new_webmaster_balance) + 1
				},
				advertiserDownBalance: function() {
					this.new_advertiser_balance = parseFloat(this.new_advertiser_balance) - 1
				},
				advertiserUpBalance: function() {
					this.new_advertiser_balance = parseFloat(this.new_advertiser_balance) + 1
				},
				resetAdvertiserDiff: function() {
					this.new_advertiser_balance = this.advertiser_balance
				},
				resetWebmasterDiff: function() {
					this.new_webmaster_balance = this.webmaster_balance
				},
				editBalance: function() {
					var e = this;
					this.button_active = !0, $.post("/api/admin/user/set_balance", this.$data, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1, e.complete = !0)
					}, "json")
				},
				closeModal: function() {
					this.id = null, this.username = "", this.email = "", this.role = "", this.new_webmaster_balance = "", this.new_advertiser_balance = "", this.webmaster_balance = "", this.advertiser_balance = "", this.webmaster_diff = "", this.advertiser_diff = "", this.button_active = !1, this.complete = !1, $(document).trigger("adflex.dt.reload")
				}
			},
			computed: {
				diffAdvertiserBalance: function() {
					var t = this.new_advertiser_balance - this.advertiser_balance;
					return 0 < t ? (this.advertiser_diff = "+" + parseFloat(t).toFixed(2), "+" + parseFloat(t).toFixed(2)) : (this.advertiser_diff = parseFloat(t).toFixed(2), parseFloat(t).toFixed(2))
				},
				diffWebmasterBalance: function() {
					var t = this.new_webmaster_balance - this.webmaster_balance;
					return 0 < t ? (this.webmaster_diff = "+" + parseFloat(t).toFixed(2), "+" + parseFloat(t).toFixed(2)) : (this.webmaster_diff = parseFloat(t).toFixed(2), parseFloat(t).toFixed(2))
				}
			}
		})
	}, {}],
	54: [function(t, e, a) {
		e.exports = new Vue({
			el: "#role-user",
			data: {
				id: null,
				username: "",
				subrole: "",
				button_active: !1
			},
			methods: {
				init: function(t) {
					var e = this,
						a = {
							id: t
						};
					$.post("/api/admin/user/get", a, function(t) {
						if(t.error) ADFLEX.helpers.notifyError(t.message);
						else {
							if("administrator" == t.data.role) return void ADFLEX.helpers.notifyError("Cannot edit admin!");
							e.id = t.data.id, e.username = t.data.username, e.subrole = t.data.subrole, $(e.$el).modal()
						}
					}, "json")
				},
				setRole: function() {
					var e = this;
					this.button_active = !0, $.post("/api/admin/user/set_role", this.$data, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1
					}, "json")
				},
				closeModal: function() {
					this.id = "", this.username = "", this.subrole = "", this.button_active = !1, $(document).trigger("adflex.dt.reload")
				}
			}
		})
	}, {}],
	55: [function(i, t, e) {
		$(document).on("click", ".ad-preview", function() {
			var t = {
				ad_id: $(this).attr("data")
			};
			$.getJSON("/api/advertiser/ads/get", t, function(t) {
				t.error ? ADFLEX.helpers.notifyError(t.message) : $(tmpl("dsa-preview", t.data)).modal()
			})
		}), $(document).on("click", ".item-action", function() {
			var t = $(this).attr("data-id"),
				e = $(this).attr("data-action");
			if(-1 !== ["play", "stop", "delete"].indexOf(e)) {
				var a = {
					ad_id: t
				};
				if("delete" === e && !confirm("Confirm action?")) return;
				$.post("/api/advertiser/ads/" + e, a, function(t) {
					t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), $(document).trigger("adflex.dt.reload")
				}, "json")
			} else "edit" === e && i("./vue-edit-banner").init(t)
		})
	}, {
		"./vue-edit-banner": 59
	}],
	56: [function(t, e, a) {
		t("../../datatables")({
			url: "/api/advertiser/ads/fetch",
			data: {
				camp_id: getUrlSegment(5)
			},
			order: [
				[1, "desc"]
			],
			columns: [{
				data: "ad_id",
				sortable: !1,
				render: function(t) {
					return '<input type="checkbox"\n                            class="_datatable-item"\n                            name="_datatable-item[]"\n                            value="' + t + '">'
				}
			}, {
				data: "ad_id"
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a, i) {
					return tmpl("preview", a)
				}
			}, {
				data: "status",
				render: function(t, e, a, i) {
					return tmpl("status", a)
				}
			}, {
				data: "views",
				render: function(t) {
					return numeral(t).format("0,0")
				}
			}, {
				data: "clicks",
				render: function(t) {
					return numeral(t).format("0,0")
				}
			}, {
				data: "ctr",
				render: function(t) {
					return parseFloat(t).toFixed(2)
				}
			}, {
				data: null,
				render: function(t, e, a, i) {
					return 1 == window.camp_isolated ? "—" : "cpc" === a.payment_mode ? '<small class="label label-default bg-navy">cpc</small>' : '<small class="label label-default">cpv</small>'
				}
			}, {
				data: null,
				render: function(t, e, a, i) {
					return 1 == window.camp_isolated ? "—" : "cpc" == a.payment_mode ? parseFloat(a.cpc).toFixed(2) + " " + window.current_currency : parseFloat(a.cpv).toFixed(2) + " " + window.current_currency
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a, i) {
					return tmpl("actions", a)
				}
			}],
			multiaction: function(t, e) {
				if(-1 !== ["play", "stop", "delete"].indexOf(t)) {
					var a = {
						ad_id: e
					};
					$.post("/api/advertiser/ads/" + t, a, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), $(document).trigger("adflex.dt.reload")
					}, "json")
				}
			}
		});
		var i = !1;
		$("#advertiser-adslist").DataTable({
			order: [
				[1, "desc"]
			],
			ajax: {
				url: ADFLEX.url.advertiser_get_all_ads,
				data: {
					camp_id: window.location.href.split("/")[4].replace(/\#.*/, ""),
					csrf: ADFLEX.csrf
				},
				dataSrc: function(t) {
					return t.error ? (alert(t.message), !1) : t.data
				}
			},
			fnDrawCallback: function(t) {
				0 < t.aoData.length && $("#advertiser-adslist-wrapper").removeClass("hidden"), i || ($("#advertiser-adslist_length").prepend(tmpl("advertiser-ads-multi-actions")), i = !0), $("#advertiser-ads-multi-actions").val("---"), $("#advertiser-ads-check-all").prop("checked", !1)
			},
			processing: !0,
			keepConditions: !0,
			columns: [{
				data: "ad_id",
				sortable: !1,
				render: function(t) {
					return '<input type="checkbox" class="advertiser-ad-check" name="advertiser-ad-check[]" value="' + t + '">'
				}
			}, {
				data: "ad_id"
			}, {
				data: "status",
				render: function(t, e, a, i) {
					return tmpl("advertiser-ads-status", a)
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a, i) {
					return tmpl("advertiser-ad-preview", a)
				}
			}, {
				data: "ad_url",
				sortable: !1,
				render: function(t) {
					return '<a href="' + t + '" target="_blank" data-toggle="tooltip" title="' + t + '">\n                                <i class="fa fa-external-link"></i>\n                            </a>'
				}
			}, {
				data: "views",
				render: function(t) {
					return numeral(t).format("0,0")
				}
			}, {
				data: "clicks",
				render: function(t) {
					return numeral(t).format("0,0")
				}
			}, {
				data: "ctr",
				render: function(t) {
					return parseFloat(t).toFixed(2)
				}
			}, {
				data: null,
				render: function(t, e, a, i) {
					return "cpc" === a.payment_mode ? '<small class="label label-default bg-navy">cpc</small>' : '<small class="label label-default">cpv</small>'
				}
			}, {
				data: null,
				render: function(t, e, a, i) {
					return "cpc" == a.payment_mode ? parseFloat(a.cpc).toFixed(2) + " " + window.current_currency : parseFloat(a.cpv).toFixed(2) + " " + window.current_currency
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a, i) {
					return tmpl("advertiser-ads-actions", a)
				}
			}]
		})
	}, {
		"../../datatables": 87
	}],
	57: [function(t, e, a) {
		isPage("advertiser/bannerlist(.*)") && (t("./dt"), t("./actions"), t("./vue-add-banner"))
	}, {
		"./actions": 55,
		"./dt": 56,
		"./vue-add-banner": 58
	}],
	58: [function(t, e, a) {
		e.exports = new Vue({
			el: "#add-banner",
			data: {
				allowed_sizes: [],
				camp_id: getUrlSegment(5),
				img_file: null,
				img_src: null,
				title: "",
				ad_url: "",
				payment_mode: "cpc",
				cpc: "0.01",
				cpv: "1.00",
				camp_isolated: window.camp_isolated,
				add_success: !1,
				macros_box: !1,
				active_button: !1
			},
			methods: {
				closeModal: function() {
					this.img_file = null, this.img_src = null, this.title = "", this.ad_url = "", this.payment_mode = "cpc", this.cpc = "0.01", this.cpv = "1.00", this.add_success = !1, this.macros_box = !1, this.active_button = !1, this.$nextTick(function() {
						$(this.$el).find(".selectpicker").selectpicker("refresh")
					}), $(document).trigger("adflex.dt.reload")
				},
				addBanner: function() {
					var e = this;
					this.active_button = !0;
					var t = new FormData;
					t.append("camp_id", this.camp_id), t.append("title", this.title), t.append("img_file", this.img_file), t.append("ad_url", this.ad_url), t.append("payment_mode", this.payment_mode), t.append("cpc", this.cpc), t.append("cpv", this.cpv), t.append("csrf", $("[name='csrf']").attr("content")), $.ajax({
						type: "POST",
						url: "/api/advertiser/ads/add_banner",
						enctype: "multipart/form-data",
						data: t,
						cache: !1,
						contentType: !1,
						processData: !1,
						dataType: "json",
						success: function(t) {
							t.error ? (ADFLEX.helpers.notifyError(t.message), e.active_button = !1) : (ADFLEX.helpers.notifySuccess(t.message), e.add_success = !0)
						}
					})
				},
				changeInputFile: function(t) {
					var e = this;
					if(!t.target.files[0] || -1 === ["image/jpeg", "image/jpg", "image/gif", "image/png"].indexOf(t.target.files[0].type) || 2048e3 < t.target.files[0].size) this.resetInputFile(), ADFLEX.helpers.notifyError("Image selection error!");
					else {
						e.img_file = t.target.files[0];
						var a = new Image;
						a.onload = function() {
							-1 !== e.allowed_sizes.indexOf(this.width + "x" + this.height) ? (e.img_src = this.src, e.img_w = this.width, e.img_h = this.height) : ADFLEX.helpers.notifyError("Invalid banner resolution!")
						}, a.src = (window.URL || window.webkitURL).createObjectURL(e.img_file)
					}
				},
				resetInputFile: function() {
					this.img_src = null, this.img_file = null
				},
				addMore: function() {
					this.img_file = null, this.img_src = null, this.title = "", this.add_success = !1, this.active_button = !1
				}
			},
			created: function() {
				var e = this;
				$.getJSON("/api/advertiser/ads/get_banner_properties", function(t) {
					t.data && (e.allowed_sizes = t.data.allowed_sizes, e.cpc = t.data.min_cpc, e.cpv = t.data.min_cpv)
				}), this.$nextTick(function() {
					$(this.$el).find(".selectpicker").selectpicker("refresh")
				})
			}
		})
	}, {}],
	59: [function(t, e, a) {
		e.exports = new Vue({
			el: "#edit-banner",
			data: {
				ad_id: null,
				camp_id: null,
				img_file: null,
				img_src: null,
				title: "",
				ad_url: "",
				payment_mode: "cpv",
				cpc: "",
				cpv: "",
				status: "",
				img_w: "",
				img_h: "",
				camp_isolated: window.camp_isolated,
				macros_box: !1,
				active_button: !1,
				remoderateNotise: !1
			},
			methods: {
				init: function(t) {
					var i = this,
						e = {
							ad_id: t
						};
					$.getJSON("/api/advertiser/ads/get", e, function(t) {
						if(t.error) ADFLEX.helpers.notifyError(t.message);
						else {
							i.ad_id = t.data.ad_id, i.camp_id = t.data.camp_id, i.img_src = t.data.img_url, i.title = t.data.title, i.ad_url = t.data.ad_url, i.payment_mode = t.data.payment_mode, i.cpc = parseFloat(t.data.cpc).toFixed(2), i.cpv = parseFloat(t.data.cpv).toFixed(2), i.status = t.data.status;
							var e = new Image,
								a = i;
							e.onload = function() {
								a.img_w = this.width, a.img_h = this.height
							}, e.src = i.img_src
						}
					}), $(this.$el).modal()
				},
				closeModal: function() {
					this.ad_id = null, this.camp_id = null, this.img_file = null, this.img_src = null, this.title = "", this.ad_url = "", this.payment_mode = "cpc", this.cpc = "0.01", this.cpv = "1.00", this.macros_box = !1, this.active_button = !1, this.remoderateNotise = !1, $(document).trigger("adflex.dt.reload")
				},
				updateBanner: function() {
					var e = this;
					this.active_button = !0;
					var t = new FormData;
					t.append("ad_id", this.ad_id), t.append("camp_id", this.camp_id), t.append("title", this.title), t.append("ad_url", this.ad_url), t.append("payment_mode", this.payment_mode), t.append("cpc", this.cpc), t.append("cpv", this.cpv), t.append("csrf", $("[name='csrf']").attr("content")), $.ajax({
						type: "POST",
						url: "/api/advertiser/ads/update_banner",
						enctype: "multipart/form-data",
						data: t,
						cache: !1,
						contentType: !1,
						processData: !1,
						dataType: "json",
						success: function(t) {
							t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), e.active_button = !1
						}
					})
				}
			}
		})
	}, {}],
	60: [function(t, e, a) {
		var i = t("./vue-edit-camp");
		$(document).on("click", ".item-action", function() {
			var t = $(this).attr("data-id"),
				e = $(this).attr("data-action");
			if(-1 !== ["play", "stop", "delete"].indexOf(e)) {
				var a = {
					camp_id: t
				};
				if("delete" === e && !confirm("Confirm action?")) return;
				$.post("/api/advertiser/camp/" + e, a, function(t) {
					t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), $(document).trigger("adflex.dt.reload")
				}, "json")
			} else "edit" === e && i.init(t)
		})
	}, {
		"./vue-edit-camp": 64
	}],
	61: [function(t, e, a) {
		t("../../datatables")({
			url: "/api/advertiser/camp/fetch",
			order: [
				[1, "desc"]
			],
			columns: [{
				data: "id",
				sortable: !1,
				render: function(t) {
					return '<input type="checkbox"\n                            class="_datatable-item"\n                            name="_datatable-item[]"\n                            value="' + t + '">'
				}
			}, {
				data: "id"
			}, {
				data: "name",
				render: function(t, e, a) {
					var i = ADFLEX.helpers.escapeHtml(t.substr(0, 30));
					return 1 == a.isolated ? i + ' <small class="label label-default"\n                                        style="position: relative; top:-5px"\n                                        data-toggle="tooltip"\n                                        data-title="Isolated campaign">\n                                            <i class="fa fa-lock"></i>\n                                       </small>' : i
				}
			}, {
				data: "type",
				render: function(t, e, a, i) {
					return tmpl("camp-type", a)
				}
			}, {
				data: "status",
				render: function(t, e, a, i) {
					return tmpl("camp-status", a)
				}
			}, {
				data: "theme",
				render: function(t, e, a, i) {
					return tmpl("camp-theme", a)
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, n, a) {
					var i = {
						geos: n.geos.replace(/\,/g, ", "),
						devs: n.devs.replace(/\,/g, ", "),
						platforms: n.platforms.replace("unknown_desktop_os", "Other desktop OS").replace("unknown_mobile_os", "Other mobile OS").replace(/\,/g, ", ").replace(/\_/g, " "),
						browsers: n.browsers.replace("unknown_desktop_browser", "Other desktop browser").replace("unknown_mobile_browser", "Other mobile browser").replace(/\,/g, ", ").replace(/\_d/g, "").replace(/\_m/g, "(mobile)"),
						days: function(t) {
							for(var e = n.days.split(","), a = ["", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"], i = 0; i < e.length; i++) e[i] = a[e[i]];
							return e.join(", ")
						}(),
						hours: n.hours.replace(/\,/g, ", "),
						theme: n.theme.replace(/\,/g, ", ").replace(/\_/g, "/"),
						allowed_site_themes: n.allowed_site_themes.replace(/\,/g, ", ").replace(/\_/g, "/")
					};
					return tmpl("camp-properties", i)
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a, i) {
					return tmpl("camp-dsamanage", a)
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a, i) {
					return tmpl("camp-actions", a)
				}
			}],
			multiaction: function(t, e) {
				if(-1 !== ["play", "stop", "delete"].indexOf(t)) {
					var a = {
						camp_id: e
					};
					$.post("/api/advertiser/camp/" + t, a, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), $(document).trigger("adflex.dt.reload")
					}, "json")
				}
			}
		})
	}, {
		"../../datatables": 87
	}],
	62: [function(t, e, a) {
		isPage("advertiser/campaigns(.*)") && (t("./dt"), t("./actions"), t("./vue-add-camp"))
	}, {
		"./actions": 60,
		"./dt": 61,
		"./vue-add-camp": 63
	}],
	63: [function(t, e, a) {
		e.exports = new Vue({
			el: "#add-camp",
			data: {
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
				is_complete: !1,
				isolated: 0
			},
			methods: {
				init: function() {
					var e = this;
					$.getJSON("/api/advertiser/camp/get_camp_template", function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (e.name = t.data.name, e.start_date = t.data.start_date, e.end_date = t.data.end_date, e.theme = t.data.theme, e.allowed_site_themes = t.data.allowed_site_themes, e.hours = t.data.hours, e.days = t.data.days, e.geos = t.data.geos, e.devs = t.data.devs, e.platforms = t.data.platforms, e.browsers = t.data.browsers, e.sites_bl = t.data.sites_bl, e.isolated = 0, e.button_active = !1, e.is_complete = !1, e.$nextTick(function() {
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
					this.button_active = !0, $.post("/api/advertiser/camp/add", this.$data, function(t) {
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
	64: [function(t, e, a) {
		e.exports = new Vue({
			el: "#edit-camp",
			data: {
				id: null,
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
				button_active: !1,
				isolated: 0
			},
			methods: {
				init: function(t) {
					var e = this;
					$.getJSON("/api/advertiser/camp/get", {
						camp_id: t
					}, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : (e.id = t.data.id, e.name = t.data.name, e.type = t.data.type, e.start_date = t.data.start_date, e.end_date = t.data.end_date, e.theme = t.data.theme, e.allowed_site_themes = t.data.allowed_site_themes.split(","), e.hours = t.data.hours.split(","), e.days = t.data.days.split(","), e.geos = t.data.geos.split(","), e.devs = t.data.devs.split(","), e.platforms = t.data.platforms.split(","), e.browsers = t.data.browsers.split(","), e.sites_bl = t.data.sites_bl, e.isolated = t.data.isolated, e.$nextTick(function() {
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
					this.button_active = !0, $.post("/api/advertiser/camp/update", this.$data, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1
					}, "json")
				},
				closeModal: function() {
					this.id = null, this.name = "", this.type = "", this.start_date = "", this.end_date = "", this.theme = "", this.allowed_site_themes = [], this.hours = [], this.days = [], this.geos = [], this.devs = [], this.platforms = [], this.browsers = [], this.sites_bl = [], this.button_active = !1, this.isolated = 0, $(document).trigger("adflex.dt.reload")
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
	65: [function(t, e, a) {
		if(isPage("advertiser/dashboard(.*)")) {
			new CountUp("today-views", 0, parseInt($("#today-views").text()), 0, 2).start(), new CountUp("today-clicks", 0, parseInt($("#today-clicks").text()), 0, 2).start(), new CountUp("today-ctr", 0, parseFloat($("#today-ctr").text()), 2, 2).start(), new CountUp("today-costs", 0, parseFloat($("#today-costs").text()), 2, 2).start();
			var i = document.getElementById("chart-ciews-clicks");
			new Chart(i, {
				type: "line",
				data: {
					labels: chart_labels(30),
					datasets: [{
						label: "Clicks",
						borderWidth: 1,
						backgroundColor: "rgba(0, 166, 90, .9)",
						borderColor: "rgba(0, 166, 90, .9)",
						data: chart_data(views_clicks_chart, "clicks", 30)
					}, {
						label: "Views",
						borderWidth: 1,
						backgroundColor: "RGBA(0,192,239, 0.9)",
						borderColor: "RGBA(0,192,239, 0.9)",
						data: chart_data(views_clicks_chart, "views", 30)
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: !0
							},
							gridLines: {
								display: !1
							}
						}],
						xAxes: [{
							gridLines: {
								display: !1
							}
						}]
					},
					legend: {
						labels: {
							usePointStyle: !0
						}
					},
					tooltips: {
						mode: "index",
						itemSort: function() {
							return !0
						}
					}
				}
			});
			i = document.getElementById("barChart"), new Chart(i, {
				type: "line",
				data: {
					labels: chart_labels(7),
					datasets: [{
						lineTension: 0,
						borderWidth: 3,
						backgroundColor: "#DD4B39",
						fill: !1,
						borderColor: "#DD4B39",
						pointColor: "#DD4B39",
						pointStrokeColor: "rgba(60,141,188,1)",
						pointHighlightFill: "#fff",
						pointHighlightStroke: "rgba(60,141,188,1)",
						data: chart_data(costs_chart, "costs", 7)
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: !0
							},
							gridLines: {
								display: !1
							}
						}],
						xAxes: [{
							gridLines: {
								display: !1
							}
						}]
					},
					legend: {
						display: !1
					}
				}
			}), i = document.getElementById("lineChart"), new Chart(i, {
				type: "line",
				data: {
					labels: chart_labels(7),
					datasets: [{
						lineTension: 0,
						label: "CTR",
						borderWidth: 3,
						backgroundColor: "#F39C12",
						fill: !1,
						borderColor: "#F39C12",
						pointColor: "#F39C12",
						pointStrokeColor: "rgba(60,141,188,1)",
						pointHighlightFill: "#fff",
						pointHighlightStroke: "rgba(60,141,188,1)",
						data: chart_data(ctr_chart, "ctr", 7)
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: !0
							},
							gridLines: {
								display: !1
							}
						}],
						xAxes: [{
							gridLines: {
								display: !1
							},
							barPercentage: .7
						}]
					},
					legend: {
						display: !1
					}
				}
			})
		}
	}, {}],
	66: [function(i, t, e) {
		$(document).on("click", ".ad-preview", function() {
			var t = {
				ad_id: $(this).attr("data"),
				csrf: ADFLEX.csrf
			};
			$.getJSON("/api/advertiser/ads/get", t, function(t) {
				t.err ? ADFLEX.helpers.notifyError(t.err) : $(tmpl("dsa-preview", t.data)).modal()
			})
		}), $(document).on("click", ".item-action", function() {
			var t = $(this).attr("data-id"),
				e = $(this).attr("data-action");
			if(-1 !== ["play", "stop", "delete"].indexOf(e)) {
				var a = {
					ad_id: t,
					csrf: ADFLEX.csrf
				};
				if("delete" === e && !confirm("Confirm action?")) return;
				$.post("/api/advertiser/ads/" + e, a, function(t) {
					t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), $(document).trigger("adflex.dt.reload")
				}, "json")
			} else "edit" === e && i("./vue-edit-dsa").init(t)
		})
	}, {
		"./vue-edit-dsa": 70
	}],
	67: [function(t, e, a) {
		t("../../datatables")({
			url: "/api/advertiser/ads/fetch",
			data: {
				camp_id: getUrlSegment(5)
			},
			order: [
				[1, "desc"]
			],
			columns: [{
				data: "ad_id",
				sortable: !1,
				render: function(t) {
					return '<input type="checkbox"\n                            class="_datatable-item"\n                            name="_datatable-item[]"\n                            value="' + t + '">'
				}
			}, {
				data: "ad_id"
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a, i) {
					return tmpl("preview", a)
				}
			}, {
				data: "status",
				render: function(t, e, a, i) {
					return tmpl("status", a)
				}
			}, {
				data: "views",
				render: function(t) {
					return numeral(t).format("0,0")
				}
			}, {
				data: "clicks",
				render: function(t) {
					return numeral(t).format("0,0")
				}
			}, {
				data: "ctr",
				render: function(t) {
					return parseFloat(t).toFixed(2)
				}
			}, {
				data: null,
				render: function(t, e, a, i) {
					return 1 == window.camp_isolated ? "—" : "cpc" === a.payment_mode ? '<small class="label label-default bg-navy">cpc</small>' : '<small class="label label-default">cpv</small>'
				}
			}, {
				data: null,
				render: function(t, e, a, i) {
					return 1 == window.camp_isolated ? "—" : "cpc" == a.payment_mode ? parseFloat(a.cpc).toFixed(2) + " " + window.current_currency : parseFloat(a.cpv).toFixed(2) + " " + window.current_currency
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a, i) {
					return tmpl("actions", a)
				}
			}],
			multiaction: function(t, e) {
				if(-1 !== ["play", "stop", "delete"].indexOf(t)) {
					var a = {
						ad_id: e,
						csrf: ADFLEX.csrf
					};
					$.post("/api/advertiser/ads/" + t, a, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), $(document).trigger("adflex.dt.reload")
					}, "json")
				}
			}
		});
		var i = !1;
		$("#advertiser-adslist").DataTable({
			order: [
				[1, "desc"]
			],
			ajax: {
				url: ADFLEX.url.advertiser_get_all_ads,
				data: {
					camp_id: window.location.href.split("/")[4].replace(/\#.*/, ""),
					csrf: ADFLEX.csrf
				},
				dataSrc: function(t) {
					return t.error ? (alert(t.message), !1) : t.data
				}
			},
			fnDrawCallback: function(t) {
				0 < t.aoData.length && $("#advertiser-adslist-wrapper").removeClass("hidden"), i || ($("#advertiser-adslist_length").prepend(tmpl("advertiser-ads-multi-actions")), i = !0), $("#advertiser-ads-multi-actions").val("---"), $("#advertiser-ads-check-all").prop("checked", !1)
			},
			processing: !0,
			keepConditions: !0,
			columns: [{
				data: "ad_id",
				sortable: !1,
				render: function(t) {
					return '<input type="checkbox" class="advertiser-ad-check" name="advertiser-ad-check[]" value="' + t + '">'
				}
			}, {
				data: "ad_id"
			}, {
				data: "status",
				render: function(t, e, a, i) {
					return tmpl("advertiser-ads-status", a)
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a, i) {
					return tmpl("advertiser-ad-preview", a)
				}
			}, {
				data: "ad_url",
				sortable: !1,
				render: function(t) {
					return '<a href="' + t + '" target="_blank" data-toggle="tooltip" title="' + t + '">\n                                <i class="fa fa-external-link"></i>\n                            </a>'
				}
			}, {
				data: "views",
				render: function(t) {
					return numeral(t).format("0,0")
				}
			}, {
				data: "clicks",
				render: function(t) {
					return numeral(t).format("0,0")
				}
			}, {
				data: "ctr",
				render: function(t) {
					return parseFloat(t).toFixed(2)
				}
			}, {
				data: null,
				render: function(t, e, a, i) {
					return "cpc" === a.payment_mode ? '<small class="label label-default bg-navy">cpc</small>' : '<small class="label label-default">cpv</small>'
				}
			}, {
				data: null,
				render: function(t, e, a, i) {
					return "cpc" == a.payment_mode ? parseFloat(a.cpc).toFixed(2) + " " + window.current_currency : parseFloat(a.cpv).toFixed(2) + " " + window.current_currency
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a, i) {
					return tmpl("advertiser-ads-actions", a)
				}
			}]
		})
	}, {
		"../../datatables": 87
	}],
	68: [function(t, e, a) {
		isPage("advertiser/dsalist(.*)") && (t("./dt"), t("./actions"), t("./vue-add-dsa"))
	}, {
		"./actions": 66,
		"./dt": 67,
		"./vue-add-dsa": 69
	}],
	69: [function(t, e, a) {
		e.exports = new Vue({
			el: "#add-dsa",
			data: {
				camp_id: null,
				img_file: null,
				img_src: null,
				title: "",
				camp_isolated: window.camp_isolated,
				description: "",
				ad_url: "",
				payment_mode: "cpc",
				cpc: "0.01",
				cpv: "1.00",
				action_text: "",
				add_success: !1,
				macros_box: !1,
				active_button: !1
			},
			methods: {
				closeModal: function() {
					this.img_file = null, this.img_src = null, this.title = "", this.description = "", this.ad_url = "", this.payment_mode = "cpc", this.cpc = "0.01", this.cpv = "1.00", this.add_success = !1, this.macros_box = !1, this.active_button = !1, $(document).trigger("adflex.dt.reload")
				},
				addDsa: function() {
					var e = this;
					this.active_button = !0;
					var t = new FormData;
					t.append("camp_id", this.camp_id), t.append("title", this.title), t.append("description", this.description), t.append("img_file", this.img_file), t.append("ad_url", this.ad_url), t.append("payment_mode", this.payment_mode), t.append("cpc", this.cpc), t.append("cpv", this.cpv), t.append("csrf", ADFLEX.csrf), t.append("action_text", this.action_text), $.ajax({
						type: "POST",
						url: "/api/advertiser/ads/add_ads",
						enctype: "multipart/form-data",
						data: t,
						cache: !1,
						contentType: !1,
						processData: !1,
						dataType: "json",
						success: function(t) {
							t.error ? (ADFLEX.helpers.notifyError(t.message), e.active_button = !1) : (ADFLEX.helpers.notifySuccess(t.message), e.add_success = !0)
						}
					})
				},
				formatedCPC: function() {
					var t = parseFloat(this.cpc);
					100 < t && (t = 100), t < .01 && (t = .01), isNaN(t) && (t = .01), this.cpc = t.toFixed(2)
				},
				formatedCPV: function() {
					var t = parseFloat(this.cpv);
					100 < t && (t = 100), t < 1 && (t = 1), isNaN(t) && (t = 1), this.cpv = t.toFixed(2)
				},
				changeInputFile: function(t) {
					var e = this;
					if(!t.target.files[0] || -1 === ["image/jpeg", "image/jpg", "image/gif", "image/png"].indexOf(t.target.files[0].type) || 2048e3 < t.target.files[0].size) this.resetInputFile(), ADFLEX.helpers.notifyError("Image selection error!");
					else {
						e.img_file = t.target.files[0];
						var a = new Image;
						a.onload = function() {
							e.img_src = this.src, e.img_w = this.width, e.img_h = this.height, e.img_w < 300 && (ADFLEX.helpers.notifyError("Image width must be at least 300 px"), e.resetInputFile()), e.img_h < 250 && (ADFLEX.helpers.notifyError("Image height must be at least 250 px"), e.resetInputFile())
						}, a.src = (window.URL || window.webkitURL).createObjectURL(e.img_file)
					}
				},
				resetInputFile: function() {
					this.img_src = null, this.img_file = null
				},
				addMore: function() {
					this.img_file = null, this.img_src = null, this.title = "", this.description = "", this.add_success = !1, this.active_button = !1
				}
			},
			created: function() {
				this.banner_name = "Ad - " + Math.random().toString().substr(2, 5), this.camp_id = getUrlSegment(5), this.$nextTick(function() {
					$(this.$el).find(".selectpicker").selectpicker("refresh")
				})
			}
		})
	}, {}],
	70: [function(t, e, a) {
		e.exports = new Vue({
			el: "#edit-dsa",
			data: {
				ad_id: null,
				camp_id: null,
				img_file: null,
				img_src: null,
				title: "",
				description: "",
				ad_url: "",
				payment_mode: "cpv",
				cpc: "",
				cpv: "",
				status: "",
				img_w: "",
				img_h: "",
				camp_isolated: window.camp_isolated,
				action_text: "",
				macros_box: !1,
				active_button: !1,
				remoderateNotise: !1
			},
			methods: {
				init: function(t) {
					var e = this,
						a = {
							ad_id: t
						};
					$.getJSON("/api/advertiser/ads/get", a, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : (e.ad_id = t.data.ad_id, e.camp_id = t.data.camp_id, e.img_src = t.data.img_url, e.title = t.data.title, e.description = t.data.description, e.ad_url = t.data.ad_url, e.payment_mode = t.data.payment_mode, e.cpc = parseFloat(t.data.cpc).toFixed(2), e.cpv = parseFloat(t.data.cpv).toFixed(2), e.status = t.data.status, e.action_text = t.data.action_text || "")
					}), $(this.$el).modal()
				},
				closeModal: function() {
					this.ad_id = null, this.camp_id = null, this.img_file = null, this.img_src = null, this.title = "", this.description = "", this.ad_url = "", this.payment_mode = "cpc", this.cpc = "0.01", this.cpv = "1.00", this.macros_box = !1, this.active_button = !1, this.remoderateNotise = !1, this.action_text = "", $(document).trigger("adflex.dt.reload")
				},
				updateBanner: function() {
					var e = this;
					this.active_button = !0;
					var t = new FormData;
					t.append("ad_id", this.ad_id), t.append("camp_id", this.camp_id), t.append("title", this.title), t.append("description", this.description), t.append("ad_url", this.ad_url), t.append("payment_mode", this.payment_mode), t.append("cpc", this.cpc), t.append("cpv", this.cpv), t.append("csrf", $("[name='csrf']").attr("content")), t.append("action_text", this.action_text), $.ajax({
						type: "POST",
						url: "/api/advertiser/ads/update_ads",
						enctype: "multipart/form-data",
						data: t,
						cache: !1,
						contentType: !1,
						processData: !1,
						dataType: "json",
						success: function(t) {
							t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), e.active_button = !1
						}
					})
				}
			}
		})
	}, {}],
	71: [function(t, e, a) {
		e.exports = t(12)
	}, {}],
	72: [function(t, e, a) {
		e.exports = t(12)
	}, {}],
	73: [function(t, e, a) {
		isPage("advertiser/faq(.*)") && (t("./dt"), t("./actions"))
	}, {
		"./actions": 71,
		"./dt": 72
	}],
	74: [function(t, e, a) {
		$(document).on("click", ".payment-details-btn", function() {
			var t = $(this).attr("data-payment-id");
			$.getJSON("/api/advertiser/payment/get", {
				payment_id: t
			}, function(t) {
				t.error ? ADFLEX.helpers.notifyError(t.message) : $(tmpl("payment-details-modal", t.data)).modal()
			})
		}), $(document).on("click", "#pay-stripe-btn", function() {
			$("#pay-modal").modal("hide")
		}), $("#input-amount").on("change", function() {
			var t = parseFloat($(this).val()),
				e = parseFloat($(this).attr("data-min")),
				a = parseFloat($(this).attr("data-max"));
			isNaN(t) ? t = e : a < t ? t = a : t < e && (t = e), $(this).val(t.toFixed(2)), $("#paypal-form").find('[name="amount"]').val(t.toFixed(2)), $("#stripe-form").find('[name="amount"]').val(100 * parseFloat(t))
		})
	}, {}],
	75: [function(t, e, a) {
		t("../../datatables")({
			url: "/api/advertiser/payment/fetch",
			order: [
				[0, "desc"]
			],
			columns: [{
				data: "payment_id"
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
	76: [function(t, e, a) {
		isPage("advertiser/payments(.*)") && (t("./dt"), t("./actions"))
	}, {
		"./actions": 74,
		"./dt": 75
	}],
	77: [function(t, e, a) {}, {}],
	78: [function(t, e, a) {
		isPage("advertiser/statistics/days") && t("../../datatables")({
			url: "/api/advertiser/stat/days",
			order: [
				[1, "desc"]
			],
			columns: [{
				data: null,
				sortable: !1,
				render: function(t, e, a, i) {
					return i.row + 1
				}
			}, {
				data: "date",
				render: function(t) {
					return moment(t).format("YYYY-MM-DD")
				}
			}, {
				data: "views"
			}, {
				data: "clicks"
			}, {
				data: "ctr",
				render: function(t) {
					return parseFloat(t).toFixed(2)
				}
			}, {
				data: "costs",
				render: function(t) {
					return parseFloat(t).toFixed(4)
				}
			}]
		}), isPage("advertiser/statistics/camps") && t("../../datatables")({
			url: "/api/advertiser/stat/camps",
			order: [
				[0, "asc"]
			],
			group: ["camp_id", "camp_name"],
			data: {
				start_date: function() {
					return $("body").data("start_date")
				},
				end_date: function() {
					return $("body").data("end_date")
				}
			},
			columns: [{
				data: "camp_id"
			}, {
				data: "camp_name",
				render: function(t, e, a) {
					return '<a href="/advertiser/statistics/ads?camp_id=' + a.camp_id + '">' + a.camp_name + "</a>"
				}
			}, {
				data: "views|SUM"
			}, {
				data: "clicks|SUM"
			}, {
				data: "ctr|AVG",
				render: function(t) {
					return parseFloat(t).toFixed(2)
				}
			}, {
				data: "costs|SUM",
				render: function(t) {
					return parseFloat(t).toFixed(4)
				}
			}]
		}), isPage("advertiser/statistics/ads(.*)") && t("../../datatables")({
			url: "/api/advertiser/stat/ads",
			order: [
				[0, "asc"]
			],
			group: ["ad_id", "camp_id", "camp_name"],
			data: {
				start_date: function() {
					return $("body").data("start_date")
				},
				end_date: function() {
					return $("body").data("end_date")
				},
				filter_camp_id: window.filter_camp_id
			},
			columns: [{
				data: "camp_id"
			}, {
				data: "camp_name",
				render: function(t, e, a) {
					return null === window.filter_camp_id ? '<a href="/advertiser/statistics/ads?camp_id=' + a.camp_id + '">' + a.camp_name + "</a>" : a.camp_name
				}
			}, {
				data: "ad_id"
			}, {
				data: "views|SUM"
			}, {
				data: "clicks|SUM"
			}, {
				data: "ctr|AVG",
				render: function(t) {
					return parseFloat(t).toFixed(2)
				}
			}, {
				data: "costs|SUM",
				render: function(t) {
					return parseFloat(t).toFixed(4)
				}
			}]
		})
	}, {
		"../../datatables": 87
	}],
	79: [function(t, e, a) {
		isPage("advertiser/statistics(.*)") && (t("./dt"), t("./actions"))
	}, {
		"./actions": 77,
		"./dt": 78
	}],
	80: [function(t, e, a) {
		$(function() {
			var t = localStorage.getItem("adflex");
			$(".change-user-subrole").on("click", function() {
				var t = {
					to_role: $(this).attr("data-to-role")
				};
				$.post("/auth/api_change_user_subrole/", t, function(t) {
					t.error ? alert(t.message) : (localStorage.setItem("adflex", Math.random()), window.location.replace("/"))
				}, "json")
			}), $(window).on("storage", function() {
				t != localStorage.getItem("adflex") && window.location.replace("/")
			})
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
			banners_sizes: ["468x60", "728x90", "250x250", "200x200", "336x280", "300x250", "120x600", "160x600", "300x600", "240x400", "970x90", "970x250", "320x100", "320x50", "600x200", "468x120"],
			themes: ["auto_moto", "business_finance", "house_family", "health_fitness", "games", "career_work", "cinema", "beauty_cosmetics", "cookery", "fashion_clothes", "music", "the_property", "news", "society", "entertainment", "sport", "science", "goods", "tourism", "adult", "other"],
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
	86: [function(t, e, a) {
		$(function() {
			$(document).on("click", "[go-to-user-account]", function() {
				var t = $(this).attr("data-user-id");
				$.post("/api/admin/account/to_user", {
					userId: t
				}, function(t) {
					t.error ? ADFLEX.helpers.notifyError(t.message) : window.location.replace("/")
				}, "json")
			}), $(document).on("click", "[go-to-admin-account]", function() {
				$.post("/api/admin/account/to_admin", function(t) {
					t.error ? ADFLEX.helpers.notifyError(t.message) : window.location.replace("/administrator/users")
				}, "json")
			})
		})
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
			window.ADFLEX = t("./cfg"), t("./t-tabs"), t("./global"), t("./translations"), t("./vue_filters"), t("./vue_components/timezone"), t("./vue_components"), t("./daterangepicker"), t("./auth/login"), t("./auth/register"), t("./auth/forgot"), t("./auth/reset-password"), t("./auth/change-user-subrole"), t("./admin/users/index"), t("./admin/support/index"), t("./admin/statistics/index"), t("./admin/sites/index"), t("./admin/settings/index"), t("./admin/payouts/index"), t("./admin/payments/index"), t("./admin/faq/index"), t("./admin/ads/index"), t("./admin/units/index"), t("./admin/dashboard/index"), t("./admin/campaigns/index"), t("./advertiser/bannerlist/index"), t("./advertiser/campaigns/index"), t("./advertiser/dashboard/index"), t("./advertiser/dsalist/index"), t("./advertiser/faq/index"), t("./advertiser/payments/index"), t("./advertiser/statistics/index"), t("./webmaster/units/index"), t("./webmaster/dashboard/index"), t("./webmaster/faq/index"), t("./webmaster/payouts/index"), t("./webmaster/settings/index"), t("./webmaster/sites/index"), t("./webmaster/statistics/index"), t("./webmaster/support/index"), t("./moderator/campaigns/index"), t("./moderator/ads/index"), t("./moderator/settings/index"), t("./moderator/sites/index"), t("./moderator/support/index"), t("./changeAccounts")
		})
	}, {
		"./admin/ads/index": 4,
		"./admin/campaigns/index": 8,
		"./admin/dashboard/index": 11,
		"./admin/faq/index": 14,
		"./admin/payments/index": 17,
		"./admin/payouts/index": 20,
		"./admin/settings/index": 26,
		"./admin/sites/index": 30,
		"./admin/statistics/index": 36,
		"./admin/support/index": 39,
		"./admin/units/index": 44,
		"./admin/users/index": 51,
		"./advertiser/bannerlist/index": 57,
		"./advertiser/campaigns/index": 62,
		"./advertiser/dashboard/index": 65,
		"./advertiser/dsalist/index": 68,
		"./advertiser/faq/index": 73,
		"./advertiser/payments/index": 76,
		"./advertiser/statistics/index": 79,
		"./auth/change-user-subrole": 80,
		"./auth/forgot": 81,
		"./auth/login": 82,
		"./auth/register": 83,
		"./auth/reset-password": 84,
		"./cfg": 85,
		"./changeAccounts": 86,
		"./daterangepicker": 88,
		"./global": 90,
		"./moderator/ads/index": 93,
		"./moderator/campaigns/index": 97,
		"./moderator/settings/index": 102,
		"./moderator/sites/index": 106,
		"./moderator/support/index": 112,
		"./t-tabs": 115,
		"./translations": 116,
		"./vue_components": 117,
		"./vue_components/timezone": 122,
		"./vue_filters": 125,
		"./webmaster/dashboard/index": 126,
		"./webmaster/faq/index": 129,
		"./webmaster/payouts/index": 132,
		"./webmaster/settings/index": 136,
		"./webmaster/sites/index": 140,
		"./webmaster/statistics/index": 145,
		"./webmaster/support/index": 148,
		"./webmaster/units/index": 156,
		domready: 163
	}],
	90: [function(t, e, a) {
		var i = t("../../../env");
		window.chart_labels = function() {
			for(var t = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 30, e = [], a = 0; a < t; a++) e.push(moment().subtract(a, "days").format("YYYY-MM-DD"));
			return e.reverse()
		}, window.array_fill = function(t, e) {
			for(var a = [], i = 0; i < t; i++) a.push(e);
			return a
		}, window.chart_data = function(r, o) {
			var t = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : 30,
				d = [],
				e = chart_labels(t);
			return r.length ? ($.each(e, function(t, e) {
				var a, i, n, s;
				d.push((a = e, i = o, n = r, s = 0, $.each(n, function(t, e) {
					if(moment(a).format("YYYY-MM-DD") == moment(e.date).format("YYYY-MM-DD")) return s = e[i], !1
				}), s))
			}), d) : array_fill(t, 0)
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
	91: [function(t, e, a) {
		var i = t("./vue-moderate");
		$(document).on("click", ".dsa-action", function() {
			var t = {
					ad_id: $(this).attr("data-id")
				},
				e = $(this).attr("data-action"),
				a = "";
			if("play" === e) a = "/api/moderator/ads/play";
			else if("stop" === e) a = "/api/moderator/ads/stop";
			else if("ban" === e) {
				if(t.status_message = prompt("Specify the reason for the ban.", ""), !t.status_message) return;
				a = "/api/moderator/ads/ban"
			} else if("unban" === e) a = "/api/moderator/ads/unban";
			else {
				if("edit" === e) return;
				if("moderate" === e) return void i.init(t.ad_id)
			}
			$.post(a, t, function(t) {
				t.error ? ADFLEX.helpers.notifyError(t.message) : (ADFLEX.helpers.notifySuccess(t.message), $(document).trigger("adflex.dt.reload"))
			}, "json")
		}), $(document).on("click", ".ad-preview", function() {
			var t = {
				ad_id: $(this).attr("data")
			};
			$.getJSON("/api/moderator/ads/get", t, function(t) {
				t.error ? ADFLEX.helpers.notifyError(t.message) : $(tmpl("dsa-preview", t.data)).modal()
			})
		})
	}, {
		"./vue-moderate": 94
	}],
	92: [function(t, e, a) {
		t("../../datatables")({
			url: "/api/moderator/ads/fetch",
			data: {
				filter_user_id: window.filter_user_id
			},
			order: [
				[0, "desc"]
			],
			columns: [{
				data: "ad_id"
			}, {
				data: "user_id",
				render: function(t, e, a) {
					return tmpl("userdata", a)
				}
			}, {
				data: "camp_id",
				render: function(t, e, a) {
					return tmpl("camp", a)
				}
			}, {
				data: "payment_mode",
				render: function(t, e, a) {
					return tmpl("payment", {
						mode: a.payment_mode.toUpperCase(),
						cpc: numeral(a.cpc).format("0,0.00"),
						cpv: numeral(a.cpv).format("0,0.00")
					})
				}
			}, {
				data: "status",
				render: function(t, e, a) {
					return tmpl("status", a)
				}
			}, {
				data: "type",
				render: function(t, e, a, i) {
					return tmpl("type", a)
				}
			}, {
				data: "preview",
				sortable: !1,
				render: function(t, e, a) {
					return tmpl("preview", a)
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
	93: [function(t, e, a) {
		isPage("moderator/ads(.*)") && (t("./dt"), t("./actions"))
	}, {
		"./actions": 91,
		"./dt": 92
	}],
	94: [function(t, e, a) {
		e.exports = new Vue({
			el: "#moderate-dsa",
			data: {
				ad_id: null,
				hash_id: "",
				user_id: "",
				camp_id: "",
				camp_theme: "",
				title: "",
				description: "",
				ad_url: "",
				img_url: "",
				img_width: "",
				img_height: "",
				cpc: "",
				cpv: "",
				payment_mode: "",
				status_message: "",
				type: "",
				reject_message: "",
				rejectMessageError: !1,
				button_success_active: !1,
				button_reject_active: !1,
				action_text: ""
			},
			methods: {
				reject: function() {
					var e = this;
					if(this.reject_message.length < 3) this.rejectMessageError = !0;
					else {
						var t = {
							ad_id: this.ad_id,
							status: -2,
							status_message: this.reject_message
						};
						this.button_reject_active = !0, $.post("/api/moderator/ads/moderate", t, function(t) {
							t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), e.button_reject_active = !1
						}, "json")
					}
				},
				accept: function() {
					var e = this,
						t = {
							ad_id: this.ad_id,
							status: 1,
							status_message: ""
						};
					this.button_success_active = !0, $.post("/api/moderator/ads/moderate", t, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), e.button_success_active = !1
					}, "json")
				},
				closeModal: function() {
					this.ad_id = null, this.hash_id = "", this.user_id = "", this.camp_id = "", this.camp_theme = "", this.title = "", this.description = "", this.ad_url = "", this.img_url = "", this.img_width = "", this.img_height = "", this.cpc = "", this.cpv = "", this.payment_mode = "", this.status_message = "", this.type = "", this.reject_message = "", this.rejectMessageError = !1, this.button_reject_active = !1, this.button_success_active = !1, this.action_text = "", $(document).trigger("adflex.dt.reload")
				},
				init: function(t) {
					var e = this,
						a = {
							ad_id: t
						};
					$.getJSON("/api/moderator/ads/get", a, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : (e.ad_id = t.data.ad_id, e.hash_id = t.data.hash_id, e.user_id = t.data.user_id, e.camp_id = t.data.camp_id, e.camp_theme = t.data.camp_theme, e.title = t.data.title, e.description = t.data.description, e.ad_url = t.data.ad_url, e.img_url = t.data.img_url, e.img_width = t.data.img_width, e.img_height = t.data.img_height, e.cpc = t.data.cpc, e.cpv = t.data.cpv, e.payment_mode = t.data.payment_mode, e.status_message = t.data.status_message, e.type = t.data.type, e.reject_message = t.data.status_message, e.action_text = t.data.action_text, e.$nextTick(function() {
							$(this.$el).find(".selectpicker").selectpicker("refresh"), this.camp_theme = $(this.$el).find(".selectpicker option:selected").text(), $(this.$el).modal()
						}))
					})
				},
				moderateNext: function() {
					var e = this,
						t = {
							ad_id: this.ad_id
						};
					$.getJSON("/api/moderator/ads/get_unmoderate_ad", t, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : (e.ad_id = t.data.ad_id, e.hash_id = t.data.hash_id, e.user_id = t.data.user_id, e.camp_id = t.data.camp_id, e.camp_theme = t.data.camp_theme, e.title = t.data.title, e.description = t.data.description, e.ad_url = t.data.ad_url, e.img_url = t.data.img_url, e.img_width = t.data.img_width, e.img_height = t.data.img_height, e.cpc = t.data.cpc, e.cpv = t.data.cpv, e.payment_mode = t.data.payment_mode, e.status_message = t.data.status_message, e.type = t.data.type, e.reject_message = t.data.status_message, e.action_text = t.data.action_text, e.$nextTick(function() {
							$(this.$el).find(".selectpicker").selectpicker("refresh"), this.camp_theme = $(this.$el).find(".selectpicker2 option:selected").text(), $(this.$el).modal()
						}))
					})
				}
			}
		})
	}, {}],
	95: [function(t, e, a) {
		var i = t("./vue-edit-camp");
		$(document).on("click", ".camp-action", function() {
			var t = {
					camp_id: $(this).attr("data-id")
				},
				e = $(this).attr("data-action"),
				a = "";
			if("play" === e) a = "/api/moderator/camp/play";
			else if("stop" === e) a = "/api/moderator/camp/stop";
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
		"./vue-edit-camp": 99
	}],
	96: [function(t, e, a) {
		t("../../datatables")({
			url: "/api/moderator/camp/fetch",
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
					return null === window.filter_user_id ? '<a href="/moderator/campaigns?user_id=' + a.user_id + '">' + a.username + "</a>" : a.username
				}
			}, {
				data: "name",
				render: function(t) {
					return ADFLEX.helpers.escapeHtml(t.substr(0, 30))
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
	97: [function(t, e, a) {
		isPage("moderator/campaigns(.*)") && (t("./dt"), t("./actions"), t("./vue-add-camp"))
	}, {
		"./actions": 95,
		"./dt": 96,
		"./vue-add-camp": 98
	}],
	98: [function(t, e, a) {
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
					$.getJSON("/api/moderator/camp/get_camp_template", function(t) {
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
					this.button_active = !0, $.post("/api/moderator/camp/add", this.$data, function(t) {
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
	99: [function(t, e, a) {
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
					$.getJSON("/api/moderator/camp/get", {
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
					this.button_active = !0, $.post("/api/moderator/camp/update", this.$data, function(t) {
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
	100: [function(t, e, a) {
		e.exports = t(12)
	}, {}],
	101: [function(t, e, a) {
		e.exports = t(12)
	}, {}],
	102: [function(t, e, a) {
		isPage("moderator/settings(.*)") && (t("./dt"), t("./actions"), t("./vue-settings"))
	}, {
		"./actions": 100,
		"./dt": 101,
		"./vue-settings": 103
	}],
	103: [function(t, e, a) {
		e.exports = new Vue({
			el: "#app-settings",
			data: {
				lang: "",
				timezone: "",
				old_password: "",
				new_password: "",
				button_active: !1,
				init: !1
			},
			methods: {
				get: function() {
					var e = this;
					$.getJSON("/api/moderator/settings/get", {
						csrf: this.csrf
					}, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : (e.lang = t.data.lang, e.timezone = t.data.timezone, e.init = !0, e.selectpicker())
					})
				},
				set: function() {
					var e = this;
					this.button_active = !0, $.post("/api/moderator/settings/set", this.$data, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1, setTimeout(function() {
							return location.reload()
						}, 1500))
					}, "json")
				},
				selectpicker: function() {
					this.$nextTick(function() {
						$(this.$el).find(".selectpicker").selectpicker("refresh")
					})
				}
			},
			created: function() {
				this.get()
			}
		})
	}, {}],
	104: [function(t, e, a) {
		var i = t("./vue-edit-site"),
			n = t("./vue-moderate");
		$(document).on("click", ".site-action", function() {
			var t = {
					site_id: $(this).attr("data-id"),
					csrf: ADFLEX.csrf
				},
				e = $(this).attr("data-action"),
				a = "";
			if("play" === e) a = "/api/moderator/site/play";
			else if("stop" === e) a = "/api/moderator/site/stop";
			else if("ban" === e) {
				if(t.ban_message = prompt("Specify the reason for the ban.", ""), !t.ban_message) return;
				a = "/api/moderator/site/ban"
			} else if("unban" === e) a = "/api/moderator/site/unban";
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
		"./vue-edit-site": 108,
		"./vue-moderate": 109
	}],
	105: [function(t, e, a) {
		t("../../datatables")({
			url: "/api/moderator/site/fetch",
			data: {
				filter_user_id: window.filter_user_id
			},
			order: [
				[0, "desc"]
			],
			columns: [{
				data: "site_id"
			}, {
				data: "user_id"
			}, {
				data: "username",
				render: function(t, e, a) {
					return null === window.filter_user_id ? '<a href="/moderator/sites?user_id=' + a.user_id + '">' + a.username + "</a>" : a.username
				}
			}, {
				data: "domain",
				render: function(t, e, a) {
					t = ADFLEX.helpers.escapeHtml(t.substr(0, 30));
					return 1 == a.isolated ? t + '  <small class="label label-default"\n                                        style="position: relative; top:-5px"\n                                        data-toggle="tooltip"\n                                        data-title="Isolated site">\n                                            <i class="fa fa-lock"></i>\n                                       </small>' : t
				}
			}, {
				data: "status",
				render: function(t, e, a, i) {
					return tmpl("site-status", a)
				}
			}, {
				data: "theme",
				render: function(t, e, a, i) {
					return tmpl("site-theme", a)
				}
			}, {
				data: "allowed_camp_themes",
				sortable: !1,
				render: function(t, e, a, i) {
					var n = window.ADFLEX.themes,
						s = a.allowed_camp_themes.split(","),
						r = {
							count_all_themes: n.length,
							count_enabled_themes: s.length,
							count_disabled_themes: n.length - s.length,
							themes: JSON.stringify({
								domain: a.domain,
								enabled: s,
								disabled: $(n).not(s).get()
							})
						};
					return tmpl("site-allowed-camp-themes", r)
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a, i) {
					return tmpl("site-actions", a)
				}
			}]
		})
	}, {
		"../../datatables": 87
	}],
	106: [function(t, e, a) {
		isPage("moderator/sites(.*)") && (t("./dt"), t("./actions"), t("./vue-add-site"))
	}, {
		"./actions": 104,
		"./dt": 105,
		"./vue-add-site": 107
	}],
	107: [function(t, e, a) {
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
					this.button_active = !0, $.post("/api/moderator/site/add", this.$data, function(t) {
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
	108: [function(t, e, a) {
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
					this.button_active = !0, $.post("/api/moderator/site/update", this.$data, function(t) {
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
					$.getJSON("/api/moderator/site/get", {
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
	109: [function(t, e, a) {
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
				button_success_active: !1,
				button_reject_active: !1
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
						this.button_reject_active = !0, $.post("/api/moderator/site/moderate", t, function(t) {
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
					this.button_success_active = !0, $.post("/api/moderator/site/moderate", t, function(t) {
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
					$.getJSON("/api/moderator/site/get", a, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : (e.site_id = t.data.site_id, e.domain = t.data.domain, e.theme = t.data.theme, e.allowed_camp_themes = t.data.allowed_camp_themes.split(","), e.stat_url = t.data.stat_url, e.stat_login = t.data.stat_login, e.stat_password = t.data.stat_password, e.$nextTick(function() {
							$(".selectpicker").selectpicker("refresh")
						}), $(e.$el).modal())
					})
				}
			}
		})
	}, {}],
	110: [function(e, t, a) {
		var i = $(window).height() - 350;

		function n(t, e) {
			var a = {
				ticket_id: t
			};
			$.post("/api/moderator/ticket/" + e, a, function(t) {
				t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), $(document).trigger("adflex.dt.reload")
			}, "json")
		}
		$(".direct-chat-messages").css("max-height", i + "px"), $(document).on("click", ".ticket-messages", function() {
			var t = $(this).attr("data-id");
			e("./vue-ticket-messages").init(t)
		}), $(document).on("click", ".item-action", function() {
			var t = $(this).attr("data-id"),
				e = $(this).attr("data-action");
			"close" === e && confirm("Confirm action?") ? n(t, e) : "open" === e && confirm("Confirm action?") && n(t, e)
		})
	}, {
		"./vue-ticket-messages": 114
	}],
	111: [function(t, e, a) {
		t("../../datatables")({
			url: "/api/moderator/ticket/fetch",
			data: {
				filter_user_id: window.filter_user_id
			},
			order: [
				[0, "desc"]
			],
			columns: [{
				data: "ticket_id"
			}, {
				data: "user_id"
			}, {
				data: "username",
				render: function(t, e, a) {
					return null === window.filter_user_id ? '<a href="/moderator/support?user_id=' + a.user_id + '">' + a.username + "</a>" : a.username
				}
			}, {
				data: "email"
			}, {
				data: "subject",
				render: function(t, e, a) {
					return t.slice(0, 20) + "..."
				}
			}, {
				data: "status",
				render: function(t, e, a) {
					return tmpl("status", a)
				}
			}, {
				data: "date_open",
				render: function(t) {
					return toLocalDate(t)
				}
			}, {
				data: "closed_at",
				render: function(t) {
					return Date.parse(t) ? toLocalDate(t) : ""
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a) {
					return tmpl("messages", a)
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a) {
					return tmpl("actions", a)
				}
			}]
		})
	}, {
		"../../datatables": 87
	}],
	112: [function(t, e, a) {
		isPage("moderator/support(.*)") && (t("./dt"), t("./actions"), t("./vue-create-ticket"))
	}, {
		"./actions": 110,
		"./dt": 111,
		"./vue-create-ticket": 113
	}],
	113: [function(t, e, a) {
		e.exports = new Vue({
			el: "#add-ticket",
			data: {
				message: "",
				subject: "",
				user_id: null,
				button_active: !1
			},
			methods: {
				createTicket: function() {
					var e = this;
					this.button_active = !0, $.post("/api/moderator/ticket/add", this.$data, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (e.user_id = "", e.message = "", e.subject = "", e.button_active = !1, ADFLEX.helpers.notifySuccess(t.message))
					}, "json")
				},
				closeModal: function() {
					this.message = "", this.subject = "", this.user_id = null, this.button_active = !1, $(document).trigger("adflex.dt.reload")
				}
			}
		})
	}, {}],
	114: [function(t, e, a) {
		e.exports = new Vue({
			el: "#ticket-messages",
			data: {
				messages: [],
				message: "",
				ticket_id: null,
				subject: null,
				status: null,
				user_id: null,
				button_active: !1
			},
			methods: {
				init: function(t) {
					var e = this;
					this.getTicket(t, function() {
						e.getMessages(), $(e.$el).modal()
					})
				},
				getTicket: function(t, e) {
					var a = this,
						i = {
							ticket_id: t
						};
					$.post("/api/moderator/ticket/get", i, function(t) {
						return t.error ? (ADFLEX.helpers.notifyError(t.message), void(a.button_active = !1)) : (a.ticket_id = t.data.ticket_id, a.user_id = t.data.user_id, a.subject = t.data.subject, a.status = t.data.status, e())
					}, "json")
				},
				getMessages: function() {
					var e = this,
						t = {
							ticket_id: this.ticket_id
						};
					$.post("/api/moderator/message/fetch", t, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (e.messages = t.data, e.message = "", e.$nextTick(function() {
							e.scrollEnd()
						}))
					}, "json")
				},
				sendMessage: function() {
					var e = this;
					this.button_active = !0;
					var t = {
						ticket_id: this.ticket_id,
						message: this.message
					};
					$.post("/api/moderator/message/send", t, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1, e.getMessages())
					}, "json")
				},
				scrollEnd: function() {
					var t = $(".direct-chat-messages");
					t.scrollTop(t[0].scrollHeight)
				},
				closeModal: function() {
					this.messages = [], this.message = "", this.ticket_id = null, this.subject = null, this.status = null, this.user_id = null, this.button_active = !1, $(document).trigger("adflex.dt.reload")
				},
				closeTicket: function() {
					var e = this;
					if(confirm("Confirm action?")) {
						var t = {
							ticket_id: this.ticket_id
						};
						$.post("/api/moderator/ticket/close", t, function(t) {
							t.error ? ADFLEX.helpers.notifyError(t.message) : (ADFLEX.helpers.notifySuccess(t.message), $(e.$el).modal("hide"), $(document).trigger("adflex.dt.reload"))
						}, "json")
					}
				}
			}
		})
	}, {}],
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
						var t = this.api_url ? this.api_url : "/api/admin/user/search";
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
	126: [function(t, e, a) {
		if(isPage("webmaster/dashboard(.*)")) {
			new CountUp("today-views", 0, parseInt($("#today-views").text()), 0, 2).start(), new CountUp("today-clicks", 0, parseInt($("#today-clicks").text()), 0, 2).start(), new CountUp("today-ctr", 0, parseFloat($("#today-ctr").text()), 2, 2).start(), new CountUp("today-profit", 0, parseFloat($("#today-profit").text()), 2, 2).start();
			var i = document.getElementById("views-clicks-chart");
			new Chart(i, {
				type: "line",
				data: {
					labels: chart_labels(30),
					datasets: [{
						label: "Clicks",
						borderWidth: 1,
						backgroundColor: "RGBA(60,141,188, .9)",
						borderColor: "RGBA(60,141,188, .9)",
						data: chart_data(views_clicks_chart, "clicks", 30)
					}, {
						label: "Views",
						borderWidth: 1,
						backgroundColor: "RGBA(0,192,239, 0.9)",
						borderColor: "RGBA(0,192,239, 0.9)",
						data: chart_data(views_clicks_chart, "views", 30)
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: !0
							},
							gridLines: {
								display: !1
							}
						}],
						xAxes: [{
							gridLines: {
								display: !1
							}
						}]
					},
					legend: {
						labels: {
							usePointStyle: !0
						}
					},
					tooltips: {
						mode: "index",
						itemSort: function() {
							return !0
						}
					}
				}
			}), i = document.getElementById("profit-chart"), new Chart(i, {
				type: "line",
				data: {
					labels: chart_labels(7),
					datasets: [{
						lineTension: 0,
						label: "Profit",
						borderWidth: 3,
						backgroundColor: "#00A65A",
						fill: !1,
						borderColor: "#00A65A",
						pointColor: "#00A65A",
						pointStrokeColor: "rgba(60,141,188,1)",
						pointHighlightFill: "#fff",
						pointHighlightStroke: "rgba(60,141,188,1)",
						data: chart_data(profit_chart, "profit", 7)
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: !0
							},
							gridLines: {
								display: !1
							}
						}],
						xAxes: [{
							gridLines: {
								display: !1
							}
						}]
					},
					legend: {
						display: !1
					}
				}
			}), i = document.getElementById("ctr-chart"), new Chart(i, {
				type: "line",
				data: {
					labels: chart_labels(7),
					datasets: [{
						lineTension: 0,
						label: "CTR",
						borderWidth: 3,
						backgroundColor: "#F39C12",
						fill: !1,
						borderColor: "#F39C12",
						pointColor: "#F39C12",
						pointStrokeColor: "rgba(60,141,188,1)",
						pointHighlightFill: "#fff",
						pointHighlightStroke: "rgba(60,141,188,1)",
						data: chart_data(ctr_chart, "ctr", 7)
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: !0
							},
							gridLines: {
								display: !1
							}
						}],
						xAxes: [{
							gridLines: {
								display: !1
							},
							barPercentage: .7
						}]
					},
					legend: {
						display: !1
					}
				}
			})
		}
	}, {}],
	127: [function(t, e, a) {
		e.exports = t(12)
	}, {}],
	128: [function(t, e, a) {
		e.exports = t(12)
	}, {}],
	129: [function(t, e, a) {
		isPage("webmaster/faq(.*)") && (t("./dt"), t("./actions"))
	}, {
		"./actions": 127,
		"./dt": 128
	}],
	130: [function(t, e, a) {
		$(document).on("click", "[data-payout-id]", function() {
			if(confirm("Cancel payout?")) {
				var t = {
					id: $(this).attr("data-payout-id")
				};
				$.post("/api/webmaster/payout/cancel", t, function(t) {
					t.error ? ADFLEX.helpers.notifyError(t.message) : (ADFLEX.helpers.notifySuccess(t.message), $(document).trigger("adflex.dt.reload"))
				}, "json")
			}
		}), $(document).on("click", ".payout-details-btn", function() {
			var t = JSON.parse($(this).attr("data"));
			$(tmpl("payout-details-modal", t)).modal()
		})
	}, {}],
	131: [function(t, e, a) {
		t("../../datatables")({
			url: "/api/webmaster/payout/fetch",
			order: [
				[0, "desc"]
			],
			columns: [{
				data: "id"
			}, {
				data: "status",
				render: function(t, e, a) {
					return "new" == t ? '<span class="label label-info">\n                                New\n                            </span>\n                            <span data-payout-id="' + a.id + '" class="label label-default" style="cursor:pointer; margin-left:5px;">\n                                <i class="fa fa-fw fa-undo"></i>\n                                Cancel\n                            </span>' : "processing" == t ? '<span class="label label-warning">\n                            <i class="fa fa-fw fa-clock-o"></i>\n                            Processing\n                        </span>' : "success" == t ? '<span class="label label-success">\n                            <i class="fa fa-fw fa-check"></i>\n                            Success\n                        </span>' : "error" == t ? '<span class="label label-danger">\n                            <i class="fa fa-fw fa-times"></i>\n                            Error\n                        </span>' : '<span class="label label-default">\n                            <i class="fa fa-fw fa-question"></i>\n                        </span>'
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
					return numeral(a.amount).format("0,0.00") + " " + a.currency.toUpperCase()
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a) {
					return tmpl("payout-details", {
						json: JSON.stringify(a)
					})
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
			}]
		})
	}, {
		"../../datatables": 87
	}],
	132: [function(t, e, a) {
		isPage("webmaster/payouts(.*)") && (t("./dt"), t("./actions"), t("./vue-add-payout"))
	}, {
		"./actions": 130,
		"./dt": 131,
		"./vue-add-payout": 133
	}],
	133: [function(t, e, a) {
		e.exports = new Vue({
			el: "#add-payout",
			data: {
				amount: "10.00",
				button_active: !1,
				is_complete: !1
			},
			methods: {
				add: function() {
					var e = this;
					this.button_active = !0, $.post("/api/webmaster/payout/add", this.$data, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1, e.is_complete = !0)
					}, "json")
				},
				closeModal: function() {
					this.amount = "10.00", this.button_active = !1, this.is_complete = !1, $(document).trigger("adflex.dt.reload")
				}
			}
		})
	}, {}],
	134: [function(t, e, a) {
		e.exports = t(12)
	}, {}],
	135: [function(t, e, a) {
		e.exports = t(12)
	}, {}],
	136: [function(t, e, a) {
		isPage("webmaster/settings(.*)") && (t("./dt"), t("./actions"), t("./vue-settings"))
	}, {
		"./actions": 134,
		"./dt": 135,
		"./vue-settings": 137
	}],
	137: [function(t, e, a) {
		e.exports = new Vue({
			el: "#app-settings",
			data: {
				lang: "",
				timezone: "",
				payout_account: "",
				old_password: "",
				new_password: "",
				button_active: !1,
				init: !1
			},
			methods: {
				get: function() {
					var e = this;
					$.getJSON("/api/webmaster/settings/get", {
						csrf: this.csrf
					}, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : (e.lang = t.data.lang, e.timezone = t.data.timezone, e.payout_account = t.data.payout_account, e.init = !0, e.selectpicker())
					})
				},
				set: function() {
					var e = this;
					this.button_active = !0, $.post("/api/webmaster/settings/set", this.$data, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1, setTimeout(function() {
							return location.reload()
						}, 1500))
					}, "json")
				},
				selectpicker: function() {
					this.$nextTick(function() {
						$(this.$el).find(".selectpicker").selectpicker("refresh")
					})
				}
			},
			created: function() {
				this.get()
			}
		})
	}, {}],
	138: [function(t, e, a) {
		var i = t("./vue-site");
		$(document).on("click", ".site-action", function() {
			var t = {
					site_id: $(this).attr("data-id")
				},
				e = $(this).attr("data-action"),
				a = "";
			if("play" === e) a = "/api/webmaster/site/play";
			else if("stop" === e) a = "/api/webmaster/site/stop";
			else if("delete" === e) {
				if(a = "/api/webmaster/site/delete", !confirm("Confirm action?")) return
			} else "edit" === e && i.initEdit(t.site_id);
			$.post(a, t, function(t) {
				t.error ? ADFLEX.helpers.notifyError(t.message) : (ADFLEX.helpers.notifySuccess(t.message), $(document).trigger("adflex.dt.reload"))
			}, "json")
		}), $(document).on("click", ".site-allowed-ad-themes", function() {
			var t = JSON.parse($(this).attr("data")),
				e = tmpl("allowed-ad-themes-tmpl", t);
			$(e).modal()
		})
	}, {
		"./vue-site": 142
	}],
	139: [function(t, e, a) {
		t("../../datatables")({
			url: "/api/webmaster/site/fetch",
			columns: [{
				data: null,
				sortable: !1,
				render: function(t, e, a, i) {
					return '<input type="checkbox" class="_datatable-item" name="_datatable-item[]" value="' + a.site_id + '">'
				}
			}, {
				data: "site_id"
			}, {
				data: "domain",
				render: function(t, e, a) {
					t = ADFLEX.helpers.escapeHtml(t.substr(0, 40));
					return 1 == a.isolated ? t + '  <small class="label label-default"\n                                        style="position: relative; top:-5px"\n                                        data-toggle="tooltip"\n                                        data-title="Isolated site">\n                                            <i class="fa fa-lock"></i>\n                                       </small>' : t
				}
			}, {
				data: "status",
				render: function(t, e, a, i) {
					return tmpl("site-status", a)
				}
			}, {
				data: "theme",
				render: function(t, e, a, i) {
					return tmpl("site-theme", a)
				}
			}, {
				data: "allowed_camp_themes",
				sortable: !1,
				render: function(t, e, a, i) {
					var n = window.ADFLEX.themes,
						s = a.allowed_camp_themes.split(","),
						r = {
							count_all_themes: n.length,
							count_enabled_themes: s.length,
							count_disabled_themes: n.length - s.length,
							themes: JSON.stringify({
								domain: a.domain,
								enabled: s,
								disabled: $(n).not(s).get()
							})
						};
					return tmpl("site-allowed-camp-themes", r)
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a, i) {
					return tmpl("site-adunit-manage", a)
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a, i) {
					return tmpl("site-actions", a)
				}
			}],
			multiaction: function(t, e) {
				var a = "";
				"play" === t ? a = "/api/webmaster/site/play" : "stop" === t ? a = "/api/webmaster/site/stop" : "delete" === t && (a = "/api/webmaster/site/delete"), $.post(a, {
					site_id: e,
					csrf: ADFLEX.csrf
				}, function(t) {
					t.error ? ADFLEX.helpers.notifyError(t.message) : (ADFLEX.helpers.notifySuccess(t.message), $(document).trigger("adflex.dt.reload"))
				}, "json")
			}
		})
	}, {
		"../../datatables": 87
	}],
	140: [function(t, e, a) {
		isPage("webmaster/site(.*)") && (t("./dt"), t("./actions"), t("./other"), t("./vue-site"))
	}, {
		"./actions": 138,
		"./dt": 139,
		"./other": 141,
		"./vue-site": 142
	}],
	141: [function(t, e, a) {}, {}],
	142: [function(t, e, a) {
		e.exports = new Vue({
			el: "#add-site",
			data: {
				site_id: null,
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
				is_edit: !1
			},
			methods: {
				addSite: function() {
					var e = this;
					this.button_active = !0, this.is_edit ? $.post("/api/webmaster/site/update", this.$data, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1
					}, "json") : $.post("/api/webmaster/site/add", this.$data, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1
					}, "json")
				},
				closeModal: function() {
					this.site_id = null, this.domain = "", this.theme = "", this.allowed_camp_themes = ADFLEX.themes.filter(function(t) {
						return "adult" !== t
					}), this.stat_url = "", this.stat_login = "", this.stat_password = "", this.button_active = !1, this.is_edit = !1, this.refreshSelectpickers(), $(document).trigger("adflex.dt.reload")
				},
				initEdit: function(t) {
					var e = this;
					this.is_edit = !0;
					var a = {
						csrf: ADFLEX.csrf,
						site_id: t
					};
					$.getJSON("/api/webmaster/site/get", a, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : (e.site_id = t.data.site_id, e.domain = t.data.domain, e.theme = t.data.theme, e.allowed_camp_themes = t.data.allowed_camp_themes.split(","), e.stat_url = t.data.stat_url, e.stat_login = t.data.stat_login, e.stat_password = t.data.stat_password, e.isolated = t.data.isolated, e.refreshSelectpickers(), $(e.$el).modal())
					})
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
	143: [function(t, e, a) {}, {}],
	144: [function(t, e, a) {
		isPage("webmaster/statistics/days") && t("../../datatables")({
			url: "/api/webmaster/stat/days",
			order: [
				[1, "desc"]
			],
			columns: [{
				data: null,
				sortable: !1,
				render: function(t, e, a, i) {
					return i.row + 1
				}
			}, {
				data: "date",
				render: function(t) {
					return moment(t).format("YYYY-MM-DD")
				}
			}, {
				data: "views"
			}, {
				data: "clicks"
			}, {
				data: "ctr",
				render: function(t) {
					return parseFloat(t).toFixed(2)
				}
			}, {
				data: "profit",
				render: function(t) {
					return parseFloat(t).toFixed(4)
				}
			}]
		}), isPage("webmaster/statistics/sites") && t("../../datatables")({
			url: "/api/webmaster/stat/sites",
			order: [
				[0, "asc"]
			],
			group: ["site_id", "domain"],
			data: {
				start_date: function() {
					return $("body").data("start_date")
				},
				end_date: function() {
					return $("body").data("end_date")
				}
			},
			columns: [{
				data: "site_id"
			}, {
				data: "domain",
				render: function(t, e, a) {
					return '<a href="/webmaster/statistics/units?site_id=' + a.site_id + '">' + a.domain + "</a>"
				}
			}, {
				data: "views|SUM"
			}, {
				data: "clicks|SUM"
			}, {
				data: "ctr|AVG",
				render: function(t) {
					return parseFloat(t).toFixed(2)
				}
			}, {
				data: "profit|SUM",
				render: function(t) {
					return parseFloat(t).toFixed(4)
				}
			}]
		}), isPage("webmaster/statistics/units(.*)") && t("../../datatables")({
			url: "/api/webmaster/stat/units",
			order: [
				[0, "asc"]
			],
			group: ["unit_id", "site_id", "domain"],
			data: {
				start_date: function() {
					return $("body").data("start_date")
				},
				end_date: function() {
					return $("body").data("end_date")
				},
				filter_camp_id: window.filter_camp_id
			},
			columns: [{
				data: "site_id"
			}, {
				data: "domain",
				render: function(t, e, a) {
					return null === window.filter_site_id ? '<a href="/webmaster/statistics/units?site_id=' + a.site_id + '">' + a.domain + "</a>" : a.domain
				}
			}, {
				data: "unit_id"
			}, {
				data: "unit_obj",
				searchable: !1,
				render: function(t) {
					return t.name
				}
			}, {
				data: "views|SUM"
			}, {
				data: "clicks|SUM"
			}, {
				data: "ctr|AVG",
				searchable: !1,
				render: function(t) {
					return parseFloat(t).toFixed(2)
				}
			}, {
				data: "profit|SUM",
				render: function(t) {
					return parseFloat(t).toFixed(4)
				}
			}]
		})
	}, {
		"../../datatables": 87
	}],
	145: [function(t, e, a) {
		isPage("webmaster/statistics(.*)") && (t("./dt"), t("./actions"))
	}, {
		"./actions": 143,
		"./dt": 144
	}],
	146: [function(e, t, a) {
		function i(t, e) {
			var a = {
				ticket_id: t
			};
			$.post("/api/webmaster/ticket/" + e, a, function(t) {
				t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), $(document).trigger("adflex.dt.reload")
			}, "json")
		}
		$(document).on("click", ".ticket-messages", function() {
			var t = $(this).attr("data-id");
			e("./vue-ticket-messages").init(t)
		}), $(document).on("click", ".item-action", function() {
			var t = $(this).attr("data-id"),
				e = $(this).attr("data-action");
			"close" === e && confirm("Confirm action?") ? i(t, e) : "open" === e && confirm("Confirm action?") && i(t, e)
		})
	}, {
		"./vue-ticket-messages": 150
	}],
	147: [function(t, e, a) {
		t("../../datatables")({
			url: "/api/webmaster/ticket/fetch",
			order: [
				[0, "desc"]
			],
			columns: [{
				data: "ticket_id"
			}, {
				data: "subject",
				render: function(t, e, a) {
					return t.slice(0, 40) + "..."
				}
			}, {
				data: "status",
				render: function(t, e, a) {
					return tmpl("status", a)
				}
			}, {
				data: "created_at",
				render: function(t) {
					return t
				}
			}, {
				data: "closed_at",
				render: function(t) {
					return Date.parse(t) ? t : ""
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a) {
					return tmpl("messages", a)
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a) {
					return tmpl("actions", a)
				}
			}]
		})
	}, {
		"../../datatables": 87
	}],
	148: [function(t, e, a) {
		isPage("webmaster/support(.*)") && (t("./dt"), t("./actions"), t("./vue-create-ticket"))
	}, {
		"./actions": 146,
		"./dt": 147,
		"./vue-create-ticket": 149
	}],
	149: [function(t, e, a) {
		e.exports = new Vue({
			el: "#create-ticket",
			data: {
				message: "",
				subject: "",
				button_active: !1
			},
			methods: {
				createTicket: function() {
					var e = this;
					this.button_active = !0;
					var t = {
						message: this.message,
						subject: this.subject
					};
					$.post("/api/webmaster/ticket/add", t, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : (ADFLEX.helpers.notifySuccess(t.message), e.message = "", e.subject = ""), e.button_active = !1
					}, "json")
				},
				closeModal: function() {
					this.message = "", this.subject = "", this.button_active = !1, $(document).trigger("adflex.dt.reload")
				}
			}
		})
	}, {}],
	150: [function(t, e, a) {
		e.exports = new Vue({
			el: "#ticket-messages",
			data: {
				messages: [],
				message: "",
				ticket_id: null,
				subject: null,
				status: null,
				user_id: null,
				button_active: !1
			},
			methods: {
				init: function(t) {
					var e = this;
					this.getTicket(t, function() {
						e.getMessages(), $(e.$el).modal()
					})
				},
				getTicket: function(t, e) {
					var a = this,
						i = {
							ticket_id: t
						};
					$.post("/api/webmaster/ticket/get", i, function(t) {
						return t.error ? (ADFLEX.helpers.notifyError(t.message), void(a.button_active = !1)) : (a.ticket_id = t.data.ticket_id, a.user_id = t.data.user_id, a.subject = t.data.subject, a.status = t.data.status, e())
					}, "json")
				},
				getMessages: function() {
					var e = this,
						t = {
							csrf: ADFLEX.csrf,
							ticket_id: this.ticket_id
						};
					$.post("/api/webmaster/message/fetch", t, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (e.messages = t.data, e.message = "", e.$nextTick(function() {
							e.scrollEnd()
						}))
					}, "json")
				},
				sendMessage: function() {
					var e = this;
					this.button_active = !0;
					var t = {
						csrf: ADFLEX.csrf,
						ticket_id: this.ticket_id,
						message: this.message
					};
					$.post("/api/webmaster/message/send", t, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1, e.getMessages())
					}, "json")
				},
				scrollEnd: function() {
					var t = $(".direct-chat-messages");
					t.scrollTop(t[0].scrollHeight)
				},
				closeModal: function() {
					this.messages = [], this.message = "", this.ticket_id = null, this.subject = null, this.status = null, this.user_id = null, this.button_active = !1, $(document).trigger("adflex.dt.reload")
				},
				closeTicket: function() {
					var e = this;
					if(confirm("Confirm action?")) {
						var t = {
							csrf: ADFLEX.csrf,
							ticket_id: this.ticket_id
						};
						$.post("/api/webmaster/ticket/close", t, function(t) {
							t.error ? ADFLEX.helpers.notifyError(t.message) : (ADFLEX.helpers.notifySuccess(t.message), $(e.$el).modal("hide"), $(document).trigger("adflex.dt.reload"))
						}, "json")
					}
				}
			}
		})
	}, {}],
	151: [function(n, t, e) {
		var s = n("./vue-edit-bannerunit"),
			r = n("./vue-edit-mobileunit");
		$(document).on("click", ".unit-actions", function(t) {
			var e = {
					unit_id: $(this).attr("data-id"),
					csrf: ADFLEX.csrf
				},
				a = $(this).attr("data-action"),
				i = "";
			if("play" === a) i = "/api/webmaster/unit/play";
			else if("stop" === a) i = "/api/webmaster/unit/stop";
			else if("delete" === a) {
				if(!confirm("Confirm action?")) return;
				i = "/api/webmaster/unit/delete"
			} else "edit" === a && ("banner" === $(this).attr("data-unit-type") ? s.edit(e.unit_id) : "mobile" === $(this).attr("data-unit-type") ? r.edit(e.unit_id) : "ad" === $(this).attr("data-unit-type") && n("./vue-add-adunit").edit(e.unit_id));
			$.post(i, e, function(t) {
				t.error ? ADFLEX.helpers.notifyError(t.message) : (ADFLEX.helpers.notifySuccess(t.message), $(document).trigger("adflex.dt.reload"))
			}, "json")
		}), $(document).on("click", ".show-unit-code", function(t, e) {
			var a = location.href.split("/")[0],
				i = '<div class="adflexbox" id="' + $(this).attr("data-hash") + '"></div>\n<script>\n    (function(d, w) {\n        if (!w.adflex) {\n            var s = d.createElement("script");\n            s.type = "text/javascript";\n            s.src = "' + a + "//" + location.host + "/loader.js\";\n            d.getElementsByTagName('head')[0].appendChild(s);\n            w.adflex = {host: '//" + location.host + "'};\n        }\n    })(document, window);\n<\/script>";
			$("#unit-code-modal").find("textarea").val(i).end().modal({
				backdrop: "static"
			})
		}), $("#copy-unit-code-btn").tooltip({
			placement: "top",
			trigger: "manual"
		}), $("#copy-unit-code-btn").on("click", function() {
			ADFLEX.helpers.notifySuccess("Code copied to clipboard.");
			var t = $("#unit-code-modal").find("textarea");
			t.get(0).focus(), t.get(0).select(), copy(t.val())
		}), $("#unit-code-modal").on("click", "textarea", function() {
			$(this).get(0).select()
		})
	}, {
		"./vue-add-adunit": 157,
		"./vue-edit-bannerunit": 160,
		"./vue-edit-mobileunit": 161
	}],
	152: [function(t, e, a) {
		e.exports = Vue.component("ad-unit", {
			props: ["params", "unit_image"],
			data: function() {
				return {
					$unit: null
				}
			},
			methods: {
				transformUnit: function() {
					this.$unit.parent().width() < 500 ? this.$unit.addClass("adflex-unit-vertical") : this.$unit.removeClass("adflex-unit-vertical"), this.unit_image ? this.$unit.removeClass("adflex-unit-noimage adflex-unit-vertical-noimage") : this.$unit.hasClass("adflex-unit-vertical") ? this.$unit.addClass("adflex-unit-vertical-noimage") : this.$unit.addClass("adflex-unit-noimage")
				}
			},
			computed: {
				unitStyle: function() {
					return {
						"font-family": this.params.fontFamily,
						background: this.params.unitBgColor,
						"border-color": this.params.unitBorderColor
					}
				},
				titleStyle: function() {
					return {
						"font-family": this.params.fontFamily,
						color: this.params.titleColor
					}
				},
				descriptionStyle: function() {
					return {
						"font-family": this.params.fontFamily,
						color: this.params.descriptionColor
					}
				},
				buttonStyle: function() {
					return {
						"font-family": this.params.fontFamily,
						color: this.params.buttonColor,
						background: this.params.buttonBgColor,
						"border-color": this.params.buttonBorderColor
					}
				}
			},
			mounted: function() {
				var t = this;
				this.$nextTick(function() {
					t.$unit = $("#adlex-unit"), t.$unit.parents(".resizable-wrapper").sizeChanged(function() {
						t.transformUnit()
					})
				})
			},
			watch: {
				unit_image: function() {
					this.transformUnit()
				}
			},
			template: '\n    <div>\n        <div :style="unitStyle" id="adlex-unit" class="adflex-unit">\n           <a href="#" class="image"></a>\n           <div class="body">\n                <a :style="titleStyle" href="#" class="title">Lorem ipsum dolor sit amet, elit. sit amet, elit.</a>    \n                <div :style="descriptionStyle" class="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, placeat?</div>\n                <a :style="buttonStyle" class="button" href="#">google.com</a>    \n           </div>\n        </div>\n    </div>'
		})
	}, {}],
	153: [function(t, e, a) {
		e.exports = Vue.component("ad-unit-params", {
			props: ["value", "config"],
			data: function() {
				return {
					current_currency: window.current_currency
				}
			},
			template: '\n    <div>\n        <div class="form-group">\n            <label>\n                {{ __(\'Имя блока\') }}\n                <i class="fa fa-question-circle text-primary"\n                   data-toggle="tooltip"\n                   :title="__(\'Имя блока, будет видно только вам.\')">\n                </i>\n            </label>\n            <input v-model="value.name" type="text" class="form-control">\n        </div>\n        <div v-if="config.site_isolated == 0" class="form-group">\n            <label>\n                {{ __(\'Показывать в блоке обьявления с оплатой за:\') }}\n                <i class="fa fa-question-circle text-primary"\n                   data-toggle="tooltip"\n                   :title="__(\'Вы можете разрешить или запретить показывать в блоке обьявления с оплатой за клики или показы.\')">\n                </i>\n            </label>\n            <select v-model="value.allowed_payments"\n                    multiple\n                    class="form-control selectpicker"\n                    data-style="btn-default btn-flat"\n                    data-width="100%">\n                <option value=\'cpc\'>{{ __(\'Клики\') }}</option>\n                <option value=\'cpv\'>{{ __(\'Показы\') }}</option>\n            </select>\n        </div>\n        <div v-if="config.site_isolated == 0" class="row form-group">\n            <div class="col-lg-6">\n                <label>\n                    {{ __(\'Минимальная цена за клик\') }}\n                    <i class="fa fa-question-circle text-primary"\n                       data-toggle="tooltip"\n                       :title="__(\'Вы можете отключить показ баннеров, у которых цена за клик ниже требуемой\')">\n                    </i>\n                </label>\n                <div class="input-group">\n                    <span class="input-group-addon">{{ current_currency }}</span>\n                    <input-amount\n                            v-model="value.min_cpc"\n                            v-bind:min="config.min_cpc"\n                            v-bind:max="config.max_cpc">\n                    </input-amount>\n                </div>\n            </div>\n            <div class="col-lg-6">\n                <label>\n                    {{ __(\'Минимальная цена за 1000 показов\') }}\n                    <i class="fa fa-question-circle text-primary"\n                       data-toggle="tooltip"\n                       :title="__(\'Вы можете отключить показ баннеров, у которых цена за 1000 показов ниже требуемой.\')">\n                    </i>\n                </label>\n                <div class="input-group">\n                    <span class="input-group-addon">{{ current_currency }}</span>\n                    <input-amount\n                            v-model="value.min_cpv"\n                            v-bind:min="config.min_cpv"\n                            v-bind:max="config.max_cpv">\n                    </input-amount>\n                </div>\n    \n            </div>\n        </div>\n        <div class="row form-group">\n            <div class="col-lg-12">\n                <div class="checkbox">\n                    <label>\n                        <input type="checkbox"\n                               v-model="value.params.third_party_status"\n                               true-value="1"\n                               false-value="0">\n                        <b>{{ __(\'Транслировать код заглушки\') }}</b>\n                        <i class="fa fa-question-circle text-primary"\n                           data-toggle="tooltip"\n                           :title="__(\'При отсутствии подходящих баннеров от рекламодателей, вы можете настроить трансляцию кода сторонней рекламной системы. Например Google Adsense.\')">\n                        </i>\n                    </label>\n                </div>\n                <textarea\n                        v-model="value.params.third_party_code"\n                        class="form-control text-sm"\n                        rows="5"\n                        :placeholder=\'__("Вставьте сюда валидный javascript код, обвернутный в теги <script><\/script>")\'>\n                            </textarea>\n            </div>\n        </div>\n        <div class="row">\n            <div class="col-lg-12">\n                <p class="text-muted">\n                    {{ __(\'Все поля обязательны для заполнения.\') }}\n                </p>\n            </div>\n        </div>\n   \n    </div>'
		})
	}, {}],
	154: [function(t, e, a) {
		e.exports = Vue.component("ad-unit-visual-builder", {
			props: ["value"],
			data: function() {
				return {
					unit_image: !0
				}
			},
			methods: {},
			mounted: function() {
				this.unit_visual_params = this.value, this.$nextTick(function() {
					$(".resizable-wrapper").resizable({
						resizeHeight: !1,
						resizeWidthFrom: "center"
					})
				})
			},
			template: '\n<div class="row">\n\n    <div class="col-sm-8">\n        <div class="resizable-wrapper">\n            <button class="btn btn-primary pull-right" @click="unit_image = !unit_image">\n                <span v-if="!unit_image">{{ __(\'Обьявление с текстом и изображением\') }}</span>\n                <span v-else>{{ __(\'Обьявление с текстом\') }}</span>\n            </button>\n            <div class="resizable-handler">\n                <i class="fa fa-bars"></i>\n            </div>\n            <ad-unit :unit_image="unit_image" :params="value"></ad-unit>\n        </div>\n    </div>\n\n\n    <div class="col-sm-4">\n\n        <div class="row">\n            <div class="col-sm-12">\n                 <div class="visual-unit-builder-label">{{ __(\'Параметры блока\') }}</div>\n            </div>\n            <div class="col-sm-4">\n                <label>{{ __(\'Цвет заливки\') }} </label>\n                <input-colorpicker v-model="value.unitBgColor"></input-colorpicker>\n            </div>\n            <div class="col-sm-4">\n                <label>{{ __(\'Цвет обводки\') }}</label>\n                <input-colorpicker v-model="value.unitBorderColor"></input-colorpicker>\n            </div>\n            \n            <div class="col-sm-4">\n                <label>{{ __(\'Шрифт\') }}</label>\n                <div class="form-group">\n                    <select v-model="value.fontFamily" class="form-control">\n                        <option value="Arial, Helvetica, sans-serif">Arial</option>\n                        <option value="Tahoma, Geneva, sans-serif">Tahoma</option>\n                        <option value="Verdana, Geneva, sans-serif">Verdana</option>\n                        <option value="Georgia, Times New Roman, Times, serif">Georgia</option>\n                        <option value="Courier New, Courier, monospace">Courier New</option>\n                        <option value="Trebuchet MS, Helvetica, sans-serif">Trebuchet MS</option>\n                        <option value="Lucida Console, Monaco, monospace">Lucida Console</option>\n                        <option value="Palatino Linotype, Book Antiqua, Palatino, serif">Palatino Linotype</option>\n                        <option value="Times New Roman, Times, serif">Times New Roman</option>\n                        <option value="inherit">{{ __(\'Как на сайте\') }}</option>\n                    </select>\n                </div>\n            </div>\n            \n            \n        </div>\n\n        <div class="row">\n            <div class="col-sm-12">\n                 <div class="visual-unit-builder-label">{{ __(\'Параметры текста\') }} </div>\n            </div>\n            <div class="col-sm-6">\n                <label>{{ __(\'Цвет заголовка\') }}</label>\n                <input-colorpicker v-model="value.titleColor"></input-colorpicker>\n            </div>\n            <div class="col-sm-6">\n                <label>{{ __(\'Цвет описания\') }}</label>\n                <input-colorpicker v-model="value.descriptionColor"></input-colorpicker>\n            </div>\n        </div>\n\n        <div class="row">\n            <div class="col-sm-12">\n                 <div class="visual-unit-builder-label">{{ __(\'Параметры кнопки\') }} </div>\n            </div>\n            \n            <div class="col-sm-4">\n                <label>{{ __(\'Цвет кнопки\') }} </label>\n                <input-colorpicker v-model="value.buttonBgColor"></input-colorpicker>\n            </div>\n            \n            <div class="col-sm-4">\n                <label>{{ __(\'Цвет текста\') }}</label>\n                <input-colorpicker v-model="value.buttonColor"></input-colorpicker>\n            </div>\n            <div class="col-sm-4">\n                <label>{{ __(\'Цвет обводки\') }}</label>\n                <input-colorpicker v-model="value.buttonBorderColor"></input-colorpicker>\n            </div>\n        </div>\n    </div>\n</div>'
		})
	}, {}],
	155: [function(t, e, a) {
		t("../../datatables")({
			url: "/api/webmaster/unit/fetch",
			data: {
				site_id: window.location.href.split("/")[5].replace(/\#.*/, "")
			},
			columns: [{
				data: null,
				sortable: !1,
				render: function(t, e, a, i) {
					return '<input type="checkbox" class="_datatable-item" name="_datatable-item[]" value="' + a.unit_id + '">'
				}
			}, {
				data: "unit_id"
			}, {
				data: "name",
				render: function(t) {
					return ADFLEX.helpers.escapeHtml(t.substr(0, 30))
				}
			}, {
				data: "status",
				render: function(t, e, a, i) {
					return tmpl("status", a)
				}
			}, {
				data: "type",
				render: function(t, e, a, i) {
					return tmpl("type", a)
				}
			}, {
				data: "banner_size",
				render: function(t) {
					return t || "Adaptive"
				}
			}, {
				data: "allowed_payments",
				render: function(t, e, a, i) {
					if(1 == window.site_isolated) return "—";
					var n, s = t.split(",");
					return n = s[0] ? '<small class="label bg-navy">' + s[0] + "</small> " : "", n += s[1] ? '<small class="label label-default">' + s[1] + "</small>" : ""
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a, i) {
					return tmpl("get-code", a)
				}
			}, {
				data: null,
				sortable: !1,
				render: function(t, e, a, i) {
					return tmpl("actions", a)
				}
			}],
			multiaction: function(t, e) {
				var a = "";
				"play" === t ? a = "/api/webmaster/unit/play" : "stop" === t ? a = "/api/webmaster/unit/stop" : "delete" === t && (a = "/api/webmaster/unit/delete"), $.post(a, {
					unit_id: e,
					csrf: ADFLEX.csrf
				}, function(t) {
					t.error ? ADFLEX.helpers.notifyError(t.message) : (ADFLEX.helpers.notifySuccess(t.message), $(document).trigger("adflex.dt.reload"))
				}, "json")
			}
		})
	}, {
		"../../datatables": 87
	}],
	156: [function(t, e, a) {
		isPage("webmaster/units(.*)") && (t("./dt"), t("./actions"), t("./vue-add-bannerunit"), t("../../vue_components/input-colorpicker"), t("./components/adUnitParams"), t("./components/adUnitVisualBuilder"), t("./components/adUnit"), t("./vue-add-adunit"), t("./vue-add-mobileunit"))
	}, {
		"../../vue_components/input-colorpicker": 119,
		"./actions": 151,
		"./components/adUnit": 152,
		"./components/adUnitParams": 153,
		"./components/adUnitVisualBuilder": 154,
		"./dt": 155,
		"./vue-add-adunit": 157,
		"./vue-add-bannerunit": 158,
		"./vue-add-mobileunit": 159
	}],
	157: [function(t, e, a) {
		e.exports = new Vue({
			el: "#add-adunit",
			data: {
				close_modal: !1,
				unit_id: null,
				site_id: window.location.href.split("/")[5].replace(/\#.*/, ""),
				config: {
					site_isolated: window.site_isolated,
					min_cpc: window.config.min_cpc,
					max_cpc: window.config.max_cpc,
					min_cpv: window.config.min_cpv,
					max_cpv: window.config.max_cpv
				},
				unit_params: {
					name: "Text-Graphic Ad Unit - " + _.random(1e4, 9e4),
					min_cpc: "0.01",
					min_cpv: "1.00",
					allowed_payments: ["cpc", "cpv"],
					params: {
						third_party_status: 0,
						third_party_code: ""
					}
				},
				unit_visual_params: {
					fontFamily: "Arial, Helvetica, sans-serif",
					unitBgColor: "#FFFFFF",
					unitBorderColor: "#A8A8A8",
					titleColor: "#3079ed",
					descriptionColor: "#000000",
					buttonColor: "#ffffff",
					buttonBgColor: "#4D90FE",
					buttonBorderColor: "#3079ED"
				},
				button_active: !1,
				edit_mode: !1,
				button_hidden: !1
			},
			methods: {
				save: function() {
					this.edit_mode ? this.update() : this.create()
				},
				create: function() {
					var e = this;
					this.button_active = !0, $.post("/api/webmaster/unit/add_ad_unit", this.$data, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1, e.button_hidden = !0)
					}, "json")
				},
				update: function() {
					var e = this;
					this.button_active = !0, $.post("/api/webmaster/unit/update_ad_unit", this.$data, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1
					}, "json")
				},
				edit: function(t) {
					var a = this;
					this.edit_mode = !0, this.unit_id = t, $.getJSON("/api/webmaster/unit/get", {
						unit_id: t
					}, function(t) {
						if(t.error) ADFLEX.helpers.notifyError(t.message);
						else {
							a.button_active = !1, a.unit_params.allowed_payments = t.data.allowed_payments.split(","), a.unit_params.min_cpc = t.data.min_cpc, a.unit_params.min_cpv = t.data.min_cpv, a.unit_params.name = t.data.name;
							var e = JSON.parse(t.data.params);
							a.unit_params.params.third_party_code = e.third_party_code, a.unit_params.params.third_party_status = e.third_party_status, a.unit_visual_params.fontFamily = e.fontFamily, a.unit_visual_params.unitBgColor = e.unitBgColor, a.unit_visual_params.unitBorderColor = e.unitBorderColor, a.unit_visual_params.titleColor = e.titleColor, a.unit_visual_params.descriptionColor = e.descriptionColor, a.unit_visual_params.buttonColor = e.buttonColor, a.unit_visual_params.buttonBgColor = e.buttonBgColor, a.unit_visual_params.buttonBorderColor = e.buttonBorderColor, $(a.$el).modal()
						}
					})
				},
				closeModal: function() {
					this.close_modal = _.now();
					var t = JSON.parse($(document.body).data("#add-adunit"));
					for(var e in t) this[e] = t[e];
					this.name = "Text-Graphic Ad Unit - " + _.random(1e4, 9e4), $(document).trigger("adflex.dt.reload")
				}
			},
			created: function() {
				$(document.body).data("#add-adunit", JSON.stringify(this.$data)), $(document).on("click", "[href='#tab_2']", function() {
					$(this).parents(".modal-dialog").animate({
						width: "95%"
					})
				}), $(document).on("click", "[href='#tab_1']", function() {
					$(this).parents(".modal-dialog").animate({
						width: "600px"
					})
				})
			}
		})
	}, {}],
	158: [function(t, e, a) {
		e.exports = new Vue({
			el: "#add-bannerunit",
			data: {
				site_id: window.location.href.split("/")[5].replace(/\#.*/, ""),
				name: "Banner-unit - " + Math.random().toString().slice(2, 7),
				type: "banner",
				min_cpc: "0.01",
				min_cpv: "1.00",
				banner_size: "300x250",
				allowed_payments: ["cpc", "cpv"],
				allowed_banners_sizes: window.BANNERS_SIZES,
				site_isolated: window.site_isolated,
				params: {
					third_party_status: 0,
					third_party_code: ""
				},
				button_active: !1,
				complete: !1
			},
			methods: {
				addBannerUnit: function() {
					var e = this;
					this.button_active = !0, $.post("/api/webmaster/unit/add_bannerunit", this.$data, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1, e.complete = !0)
					}, "json")
				},
				closeModal: function() {
					this.name = "Banner-unit - " + Math.random().toString().slice(2, 7), this.min_cpc = "0.01", this.min_cpv = "1.00", this.banner_size = "300x250", this.allowed_payments = ["cpc", "cpv"], this.params = {
						third_party_status: 0,
						third_party_code: ""
					}, this.button_active = !1, this.complete = !1, $(document).trigger("adflex.dt.reload")
				}
			},
			created: function() {
				this.$nextTick(function() {
					$(this.$el).find(".selectpicker").selectpicker("refresh")
				})
			}
		})
	}, {}],
	159: [function(t, e, a) {
		e.exports = new Vue({
			el: "#add-mobileunit",
			data: {
				site_id: window.location.href.split("/")[5].replace(/\#.*/, ""),
				name: "Mobile-unit - " + Math.random().toString().slice(2, 7),
				type: "mobile",
				min_cpc: "0.01",
				min_cpv: "1.00",
				allowed_payments: ["cpc", "cpv"],
				params: {
					position: "bottom",
					show_delay: 0,
					hidden_period: 60
				},
				button_active: !1,
				is_complete: !1
			},
			methods: {
				addMobileUnit: function() {
					var e = this;
					this.button_active = !0, $.post("/api/webmaster/unit/add_mobileunit", this.$data, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1, e.is_complete = !0)
					}, "json")
				},
				closeModal: function() {
					this.name = "Mobile-unit - " + Math.random().toString().slice(2, 7), this.type = "mobile", this.min_cpc = "0.01", this.min_cpv = "1.00", this.allowed_payments = ["cpc", "cpv"], this.params = {
						position: "bottom",
						show_delay: 0,
						hidden_period: 60
					}, this.button_active = !1, this.is_complete = !1, $(document).trigger("adflex.dt.reload")
				}
			},
			created: function() {
				this.$nextTick(function() {
					$(this.$el).find(".selectpicker").selectpicker("refresh")
				})
			}
		})
	}, {}],
	160: [function(t, e, a) {
		e.exports = new Vue({
			el: "#edit-bannerunit",
			data: {
				unit_id: null,
				site_id: null,
				name: "",
				type: "banner",
				min_cpc: "0.01",
				min_cpv: "1.00",
				banner_size: "300x250",
				allowed_payments: ["cpc", "cpv"],
				allowed_banners_sizes: window.BANNERS_SIZES,
				site_isolated: window.site_isolated,
				params: {
					third_party_status: 0,
					third_party_code: ""
				},
				button_active: !1
			},
			methods: {
				updateBannerUnit: function() {
					var e = this,
						t = {
							unit_id: this.unit_id,
							site_id: this.site_id,
							name: this.name,
							type: this.type,
							min_cpc: this.min_cpc,
							min_cpv: this.min_cpv,
							banner_size: this.banner_size,
							allowed_payments: this.allowed_payments,
							params: this.params,
							csrf: this.csrf
						};
					this.button_active = !0, $.post("/api/webmaster/unit/update_bannerunit", t, function(t) {
						t.error ? (ADFLEX.helpers.notifyError(t.message), e.button_active = !1) : (ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1, e.is_complete = !0)
					}, "json")
				},
				edit: function(t) {
					var e = this,
						a = {
							unit_id: t
						};
					$.getJSON("/api/webmaster/unit/get", a, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : (e.unit_id = t.data.unit_id, e.site_id = t.data.site_id, e.name = t.data.name, e.type = t.data.type, e.min_cpc = parseFloat(t.data.min_cpc), e.min_cpv = parseFloat(t.data.min_cpv), e.banner_size = t.data.banner_size, e.allowed_payments = t.data.allowed_payments.split(","), e.params = JSON.parse(t.data.params), e.$nextTick(function() {
							$(this.$el).find(".selectpicker").selectpicker("refresh")
						}), $(e.$el).modal())
					})
				},
				closeModal: function() {
					this.unit_id = null, this.site_id = null, this.name = "", this.type = "banner", this.min_cpc = "0.01", this.min_cpv = "1.00", this.banner_size = "300x250", this.allowed_payments = ["cpc", "cpv"], this.allowed_banners_sizes = window.BANNERS_SIZES, this.params = {
						third_party_status: 0,
						third_party_code: ""
					}, this.button_active = !1, $(document).trigger("adflex.dt.reload")
				}
			}
		})
	}, {}],
	161: [function(t, e, a) {
		e.exports = new Vue({
			el: "#edit-mobileunit",
			data: {
				site_id: window.location.href.split("/")[5].replace(/\#.*/, ""),
				unit_id: null,
				name: "",
				type: "mobile",
				min_cpc: "0.01",
				min_cpv: "1.00",
				allowed_payments: ["cpc", "cpv"],
				params: {
					position: "bottom",
					show_delay: 0,
					hidden_period: 60
				},
				button_active: !1
			},
			methods: {
				updateMobileUnit: function() {
					var e = this;
					this.button_active = !0, $.post("/api/webmaster/unit/update_mobileunit", this.$data, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : ADFLEX.helpers.notifySuccess(t.message), e.button_active = !1
					}, "json")
				},
				edit: function(t) {
					var e = this,
						a = {
							unit_id: t
						};
					$.getJSON("/api/webmaster/unit/get", a, function(t) {
						t.error ? ADFLEX.helpers.notifyError(t.message) : (e.unit_id = t.data.unit_id, e.name = ADFLEX.helpers.escapeHtml(t.data.name), e.min_cpc = t.data.min_cpc, e.min_cpv = t.data.min_cpv, e.allowed_payments = t.data.allowed_payments.split(","), e.params = JSON.parse(t.data.params), e.$nextTick(function() {
							$(this.$el).find(".selectpicker").selectpicker("refresh")
						}), $(e.$el).modal())
					})
				},
				closeModal: function() {
					this.unit_id = null, this.name = "", this.min_cpc = "0.01", this.min_cpv = "1.00", this.allowed_payments = ["cpc", "cpv"], this.params = {
						position: "bottom",
						show_delay: 0,
						hidden_period: 60
					}, this.button_active = !1, $(document).trigger("adflex.dt.reload")
				}
			}
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