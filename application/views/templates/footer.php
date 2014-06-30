			<br />
            <?php
                if ($admin_p) {
                    echo "<div float:left;><a href=\"?c=user&amp;m=logout\">Logout</a></div>";
                }
            ?>
			</div> <!-- end div indexWrapper -->
			<div id="footer">
				<div style="line-height: 70px;">
					<strong>&copy; McBluv <?php echo date('Y'); ?></strong> <!-- &copy makes the copyright sign -->
				</div>
				<div style="float:right;">
					<a style="color: black;" href="?c=user&m=login">Login</a>
				</div>
			</div> <!-- end div footer -->
	</div> <!-- end div Content -->
	</body>
</html>
