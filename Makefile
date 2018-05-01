
ROOT?=/srv/pgr

.PHONY: all git

all: git-config

srv_dirs:
	@mkdir -p $(ROOT)/config \
						$(ROOT)/db \
						$(ROOT)/storage/framework/cache \
						$(ROOT)/storage/cache \
						$(ROOT)/storage/uploads \
						$(ROOT)/storage/logs \
						$(ROOT)/storage/debugbar \
						$(ROOT)/storage/framework/cache/data \
						$(ROOT)/storage/framework/testing \
						$(ROOT)/storage/framework/views \
						$(ROOT)/storage/framework/sessions

git-config: srv_dirs
	@(cd "$(ROOT)/config";\
	if [ -d .git ]; then \
    echo "git already exists"; \
  else \
		git clone -b pgr_system https://marc-hanheide@github.com/LCAS/deployment_sec.git .; \
	fi)

fix-permissions: srv_dirs
	@(cd "$(ROOT)/";\
		chown -R www-data:www-data $(ROOT)/storage\
		)


